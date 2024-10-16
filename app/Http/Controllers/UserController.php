<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
   // public function index()
    //{
        // // coba akses model UserModel
        //$user = UserModel::all(); //ambil semua data dari tabel m_user
        //return view('user', ['data' => $user]);

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
        // $user = UserModel::create(
        //     [
        //         'username' => 'manager11',
        //         'nama' => 'Manager 11',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user->username = 'manager12';
        // $user->save();

        // $user->wasChanged(); // true
        // $user->wasChanged('username'); // true
        // $user->wasChanged(['username', 'level_id']); // true
        // $user->wasChanged('nama'); // false
        // dd ($user->wasChanged(['nama', 'username'])); // true 
    //}

     // LANGKAH 6 PRAKTIKUM 2.6 PERTEMUAN 4
   //   public function index()
   //   {
   //      $user = UserModel::all();
   //      return view('user', ['data' => $user]);  
   //   }
   //   public function tambah()
   //   {
   //      return view('user_tambah');
   //   }
   //   public function tambah_simpan(Request $request)
   //   {
   //      UserModel::create([
   //          'username' => $request->username,
   //          'nama' => $request->nama,
   //          'password' => Hash::make($request->password),
   //          'level_id' => $request->level_id
   //      ]);
   //      return redirect('/user');
   //   }
   //   public function ubah($id) 
   //   {
   //      $user = UserModel::find($id);
   //      return view('user_ubah', ['data' => $user]);
   //   }

   //   public function ubah_simpan($id, Request $request)
   //   {
   //      $user = UserModel::find($id);
   //      $user->username = $request->username;
   //      $user->nama = $request->nama;
    
   //       // Pastikan password di-hash dengan benar dan diambil dari request.
   //      $user->password = Hash::make($request->password); 
   //      $user->level_id = $request->level_id;

   //      $user->save(); // Simpan perubahan ke database

   //      return redirect('/user');
   //  }

   //  public function hapus($id)
   //  {
   //    $user = UserModel::find($id);
   //    $user->delete();
   //    return redirect('/user');
   //  }


   // // PRAKTIKUM 2.7  - PERTEMUAN 4
   // // LANGKAH 2
   // //  public function index()
   // //  {
   // //    $user = UserModel::with('level')->get();
   // //    dd($user);
   // //  }

   //  //LANGKAH 4
   //  public function index()
   //  {
   //    $user = UserModel::with('level')->get();
   //    return view('user', ['data' => $user]);
   //  }

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
            // $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
            // $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'
            //          . csrf_field() . method_field('DELETE') .
            //          '<button type="submit" class="btn btn-danger btn-sm" onclick="return
            //          confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            
            $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id .
                    '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .
                    '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .
                    '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

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

   // Menambahkan fungsi create_ajax
   public function create_ajax()
   {
       $level = LevelModel::select('level_id', 'level_nama')->get();
       return view('user.create_ajax')->with('level', $level);
   }

   // Tambahkan fungsi store_ajax untuk penyimpanan data melalui AJAX
   public function store_ajax(Request $request)
   {
   // cek apakah request berupa ajax
   if ($request->ajax() || $request->wantsJson()) {
       // Definisikan aturan validasi
       $rules = [
           'level_id' => 'required|integer',
           'username' => 'required|string|min:3|unique:m_user,username',
           'nama'     => 'required|string|max:100',
           'password' => 'required|min:6',
       ];
       // use illuminate\Support\Facades\Validator
       $validator = Validator::make($request->all(), $rules);
       // Jika validasi gagal, kembalikan pesan error dalam format JSON
       if ($validator->fails()) {
           return response()->json([
               'status' => false, // status gagal
               'message' => 'Validasi Gagal',
               'msgField' => $validator->errors(), // pesan error validasi
           ]);
       }
       // Simpan data user ke dalam database
       UserModel::create($request->all());
       // Jika berhasil, kembalikan response sukses dalam format JSON
       return response()->json([
           'status' => true,
           'message' => 'Data user berhasil disimpan'
       ]);
   }
   // Jika bukan request ajax, redirect ke halaman utama
   redirect('/');
   }

   // Menampilkan halaman form edit user ajax
   public function edit_ajax(string $id)
   {
       $user = UserModel::find($id);
       $level = LevelModel::select('level_id', 'level_nama')->get();
       return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
   }

   // Membuat fungsi update_ajax ()
   public function update_ajax(Request $request, $id) {
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ];
        
        // use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false, // respon json, true: berhasil, false: gagal
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors() // menunjukkan field mana yang error
            ]);
        }
        
        $check = UserModel::find($id);
        
        if ($check) {
            if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                $request->request->remove('password');
            }
            
            $check->update($request->all());
            
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    
    return redirect('/');
}
   
}
