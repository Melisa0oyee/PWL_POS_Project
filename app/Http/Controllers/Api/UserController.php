<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserModel; // Pastikan Anda menggunakan model yang benar

class UserController extends Controller
{
    public function index ()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $user = UserModel::create($request->all());
        return response()->json($user, 201);
    }

    public function show(UserModel $user)
    {
        return UserModel::find($user);
    }

    public function update(Request $request, UserModel $user)
    {
        $user->update($request->all());
        return UserModel::find($user);
    }
    public function destroy(UserModel $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data user terhapus',
        ]);
    }
    public function getUser( Request $request )
    {
        
        // Mendapatkan pengguna yang sedang login
        $user = auth()->guard('api')->user();

        // Jika tidak ada pengguna yang sedang login
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Mengembalikan informasi pengguna
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
            ],
        ], 200);
    }
}
