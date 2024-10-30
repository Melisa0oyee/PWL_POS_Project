<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProfilController extends Controller
{
    public function index()
    {
        $id = session('user_id');
        $breadcrumb = (object) [
            'title' => 'Profil User',
            'list' => ['Home', 'User'],
        ];
        $page = (object) [
            'title' => 'Profil',
        ];
        $activeMenu = 'profil'; //set menu yang sedang active
        // Ambil ID user yang sedang login
        $id = Auth::user()->user_id; // Atau Anda bisa menggunakan Auth::user()->id
        $user = UserModel::with('level')->find($id);
        return view('profil.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu]);
    }
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }
    // Menyimpan perubahan data user dengan AJAX termasuk file gambar
    public function update_ajax(Request $request, $id)
    {
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|max:100',
            'password' => 'nullable|min:5|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors(),
            ]);
        }

        $user = UserModel::find($id);

        if ($user) {
            if (!$request->filled('password')) {
                $request->request->remove('password');
            }

            $fileName = $user->avatar;

            if ($request->hasFile('avatar')) {
                $fileName = 'profile_' . Auth::user()->user_id . '.' . $request->avatar->getClientOriginalExtension();
                
                if (file_exists(public_path('gambar/' . $user->avatar)) && $user->avatar) {
                    unlink(public_path('gambar/' . $user->avatar));
                }

                $request->avatar->move(public_path('gambar'), $fileName);
            }

            $user->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'level_id' => $request->level_id,
                'avatar' => $fileName,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }

    return redirect('/');
}

}