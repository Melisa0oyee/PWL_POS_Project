<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    // Menampilkan halaman daftar level
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level User',
            'list' => ['Home', 'Level User']
        ];
        $page = (object) [
            'title' => 'Daftar level user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'level'; // set menu yang sedang aktif

        $level = LevelModel::all(); // ambil data level untuk filter level

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    
    // Ambil data level dalam bentuk JSON untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        // Filter data level berdasarkan level_id
        if ($request->level_id) {
            $levels->where('level_id', $request->level_id);
        }

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\''.url('/level/' . $level->level_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
        }

    // Menampilkan halaman form tambah level
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level User',
            'list' => ['Home', 'Level User', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah level user baru'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|unique:m_level,level_kode', // level_kode harus unik
            'level_nama' => 'required|string|max:100' // level_nama harus diisi dan maksimal 100 karakter
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    // Menampilkan detail level
    public function show(string $id)
    {
        $level = LevelModel::find($id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail level'
        ];
        $activeMenu = 'level'; // set menu yang sedang aktif
        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit level
    public function edit(string $id)
    {
        $level = LevelModel::find($id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit level'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif
        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data level
    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|string|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        $level = LevelModel::find($id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    // Menghapus data level
    public function destroy(string $id)
    {
        $level = LevelModel::find($id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            $level->delete(); // Hapus data level
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terkait dengan data lain');
        }
    }

    // Menambahkan fungsi create_ajax
    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    // Menyimpan data level baru melalui ajax
    public function store_ajax(Request $request)
    {
        // Definisikan aturan validasi
        $rules = [
            'level_kode' => 'required|min:2|max:10|unique:m_level,level_kode', // Kode harus unik
            'level_nama' => 'required|min:3|max:50', // Nama harus diisi dan di antara 3-50 karakter
        ];

        // Lakukan validasi menggunakan Validator
        $validator = Validator::make($request->all(), $rules);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        // Simpan data ke database jika validasi berhasil
        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        // Kirimkan response JSON berhasil
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan!',
        ]);
    }

    public function edit_ajax(string $id)
    {
        // Mengambil data level berdasarkan ID
        $level = LevelModel::find($id);
        if (!$level) {
            return response()->json([
                'status' => false,
                'message' => 'Level tidak ditemukan',
            ]);
        }

        // Mengembalikan level yang ditemukan
        return response()->json([
            'status' => true,
            'level' => $level,
        ]);
    }
    
    // Mengupdate data level melalui ajax
    public function update_ajax(Request $request, string $id)
    {
        // Cek apakah request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100',
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(), // menunjukkan field mana yang error
                ]);
            }

            // Cek apakah level ada
            $level = LevelModel::find($id);
            if ($level) {
                $level->update($request->only(['level_kode', 'level_nama'])); // Update data level
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
