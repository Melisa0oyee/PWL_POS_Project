<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;

class SupplierController extends Controller
{
    // LANGKAH 4 PRAKTIKUM 3 - PERTEMUAN 5
   public function index()
   {
      $breadcrumb = (object) [
         'title' => 'Daftar User',
         'list'  => ['Home', 'User']
      ];

      $page = (object) [
         'title' => 'Daftar user yang terdaftar dalam sistem'
      ];

      $activeMenu = 'user'; // set menu yanng sedanng aktif
      $level = LevelModel::all(); // ambil data level untuk filter level
      return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
   }

   // LANGKAH 7 PRAKTIKUM 3 - PERTEMUAN 5
   // Ambil data user dalam bentuk json untuk datatables
   public function list(Request $request)
   {
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');
    // Filter data user berdasarkan level_id
    if ($request->level_id) {
        $users->where('level_id', $request->level_id);
    }
    return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('aksi', function ($user) {
            $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'
                     . csrf_field() . method_field('DELETE') .
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
                     confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
   }

   // LANGKAH 9 PRAKTIKUM 3 - PERTEMUAN 5
   public function create()
   {
    $breadcrumb = (object) [
        'title' => 'Tambah user',
        'list' => ['Home', 'User', 'Tambah']
    ];

    $page = (object) [
        'title' => 'Tambah user baru'
    ];

    $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
    $activeMenu = 'user'; //set menu yang sedang aktif

    return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
   }

   // LANGKAH 11 PRAKTIKUM 3 - PERTEMUAN 5
   public function store(Request $request)
   {
    $request->validate([
        // username harus di isi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
        'username' => 'required|string|min:3|unique:m_user,username',
        'nama'     => 'required|string|max:100', // nama harus diisi, berupa string dan maksimal 100 karakter
        'password' => 'required|min:5',          // password harus diisi dan minimal 5 karakter
        'level_id' => 'required|integer'         // level_id harus diisi dan berupa angka
    ]);

    UserModel::create([
        'username' => $request->username,
        'nama'     => $request->nama,
        'password' => bcrypt('request->password'),  // password dienkripsi sebelum disimpan
        'level_id' => $request->level_id
    ]);
    return redirect('/user')->with('success', 'Data user baru berhasil ditambahkan');
   }

   // LANGKAH 14 PRAKTIKUM 3 - PERTEMUAN 5
   public function show(string $id)
   {
       $user = usermodel::with('level')->find($id);

       $breadcrumb = (object) [
           'title' => 'Detail user',
           'list' => ['Home', 'User', 'Detail']
       ];

       $page = (object)[
           'title' => 'Detail user'
       ];

       $activeMenu = 'user';
       return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
   }

   // LANGKAH 18 PRAKTIKUM 3 - PERTEMUAN 5
   // menampilkan halaman form edit user
   public function edit(string $id)
   {
    $user = UserModel::find($id);
    $level = LevelModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit User',
        'list'  => ['Home', 'User', 'Edit']
    ];

    $page = (object) [
        'title' => 'Edit user'
    ];

    $activeMenu = 'user'; // set menu yang sedang aktif
    return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
   }

   // menyimpan perubahan data user
   public function update(Request $request, string $id)
   {
    $request->validate([
        // username harus diisi, berupa string, minimal 3 karakter,
        // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
        'username' => 'required|string|min:3|unique:m_user,username,'.$id.'user_id',
        'nama'     => 'required|string|max:100', // nama harus diisi, berupa string dan maksimal 100 karakter
        'passowrd' => 'nullable|min:5',          // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
        'level_id' => 'required|integer'         // level_id harus diisi dan berupa angka
    ]);

    UserModel::find($id)->update([
        'username' => $request->username,
        'nama'     => $request->nama,
        'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
        'level_id' => $request->level_id
    ]);

    return redirect('/user')->with('success', 'Data user berhasil diubah');
   }

   // LANGKAH 22 PRAKTIKUM 3 - PERTEMUAN 5
   // menghapus data user
   public function destroy(string $id)
   {
    $check = UserModel::find($id);
    if (!$check) {
        return redirect('/user')->with('eror', 'Data user tidak ditemukan');
    }
    try {
        UserModel::destroy($id); // Hapus data level
        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
   }
}