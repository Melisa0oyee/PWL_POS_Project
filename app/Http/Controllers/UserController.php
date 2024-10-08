<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // // coba akses model UserModel
        // $user = UserModel::all(); //ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);

        // tambah data user dengan Eqloquent Model
        // $data = [
        //     'username' => 'customer-1',
        //     'nama'      =>  'Pelanggan',
        //     'password'  =>  Hash::make('12345'),
        //     'level_id'  =>  4
        // ];
        // UserModel::insert($data); // tambahkan data ke tabel m_user
        
        // // // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view ('user', ['data' => $user]);

        // // tambah data user dengan Eloquent Model
        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); // update data user
    
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama'     => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama'     => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // // coba akses model UserModel
        // $user = UserModel::find(1); // ambil semua data dari tabel m_user
        // return view ('user', ['data' => $user]);

        // $user = UserModel::where('level_id', 1)->first(); 
        // return view ('user', ['data' => $user]);

        // $user = UserModel::firstWhere('level_id', 1); 
        // return view ('user', ['data' => $user]);

        // $user = UserModel::findOr(1,['username','nama'], function() {
        //     abort(404);
        // }); 
        // return view ('user', ['data' => $user]);

        // $user = UserModel::findOr(20,['username','nama'], function() {
        //     abort(404);
        // }); 
        // return view ('user', ['data' => $user]);

        // $user = UserModel::findOrFail(1);
        // return view ('user', ['data' => $user]);

        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // return view ('user', ['data' => $user]);

        // // Langkah 1 prak 2.3 - pertemuan 4
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view ('user', ['data' => $user]);

        // // Langkah 3 prak 2.3 - pertemuan 4
        // $user = UserModel::where('level_id', 2)->count();
        // return view ('user', ['data' => $user]);

        // // Langkah 1 prak 2.4 - pertemuan 4
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager'
        //     ],
        // );
        // return view('user', ['data' => $user]);

        
        // // Langkah 4 prak 2.4 - pertemuan 4
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // return view('user', ['data' => $user]);


        // Langkah 6 prak 2.4 - pertemuan 4
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager'
        //     ],
        // );
        // return view('user', ['data' => $user]);


        // Langkah 8 dan 10 prak 2.4 - pertemuan 4
        //  $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user->save();
        // return view('user', ['data' => $user]);


        // LANGKAH 1 PRAK 2.5 - PERTEMUAN 4
        // $user = UserModel::create(
        //     [
        //         'username' => 'manager55',
        //         'nama' => 'Manager 55',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user->username = 'manager56';

        // $user->isDirty(); // true
        // $user->isDirty('username'); // true
        // $user->isDirty('nama'); // false
        // $user->isDirty(['nama', 'username']); // true

        // $user->isClean(); // false
        // $user->isClean('username'); // false
        // $user->isClean('nama'); // true
        // $user->isClean(['nama', 'username']); // false
        
        // $user->save();
        // $user->isDirty(); // false
        // $user->isClean(); // true
        // dd($user->isDirty());

        
        // LANGKAH 2 PRAK 2.5 - PERTEMUAN 4
        $user = UserModel::create(
            [
                'username' => 'manager11',
                'nama' => 'Manager 11',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        $user->username = 'manager12';
        $user->save();

        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged(['username', 'level_id']); // true
        $user->wasChanged('nama'); // false
        dd ($user->wasChanged(['nama', 'username'])); // true
    }
}
