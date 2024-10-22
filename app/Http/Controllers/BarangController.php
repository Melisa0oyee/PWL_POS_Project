<?php
namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    // Menampilkan halaman awal barang
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'barang';
        $kategori = KategoriModel::all();
        return view('barang.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'kategori' => $kategori, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barang = BarangModel::with('kategori')->select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id');

        if ($request->kategori_id) {
            $barang->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id .'/show').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah barang
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah barang baru'
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'barang';
        return view('barang.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'kategori' => $kategori, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_kode'  => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|numeric',
            'harga_jual'   => 'required|numeric',
            'kategori_id'  => 'required|integer'
        ]);
        BarangModel::create([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_beli'   => $request->harga_beli,
            'harga_jual'   => $request->harga_jual,
            'kategori_id'  => $request->kategori_id
        ]);
        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    /// Menampilkan detail barang
    public function show($id)
    {
        $barang = BarangModel::with('kategori')->find($id); // Memuat kategori bersamaan

        if (!$barang) {
            return redirect()->route('barang.index')->with('error', 'Data barang tidak ditemukan.');
        }

        return view('barang.show', compact('barang'));
    }

    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit barang'
        ];
        $activeMenu = 'barang';
        return view('barang.edit', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'barang' => $barang, 
            'kategori' => $kategori, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_kode'  => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|numeric',
            'harga_jual'   => 'required|numeric',
            'kategori_id'  => 'required|integer'
        ]);
        BarangModel::find($id)->update([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_beli'   => $request->harga_beli,
            'harga_jual'   => $request->harga_jual,
            'kategori_id'  => $request->kategori_id
        ]);
        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    // Menghapus data barang
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }
        try {
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // Menampilkan halaman form tambah barang dengan AJAX
    public function create_ajax()
    {
        $kategori = KategoriModel::all();
        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    // Menyimpan data barang baru melalui ajax
    public function store_ajax(Request $request)
    {
        $rules = [
            'barang_kode' => 'required|string|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors(),
                'message' => 'Validasi gagal.'
            ]);
        }

        try {
            BarangModel::create([
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'kategori_id' => $request->kategori_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ]);
        }
    }

    
   // Menampilkan halaman form edit barang
   public function edit_ajax(string $id)
   {
       $barang = BarangModel::find($id);
       $kategori = KategoriModel::all();
       return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
   }

   // Menyimpan perubahan data barang melalui AJAX
   public function update_ajax(Request $request, $id)
   {
       // cek apakah request dari ajax
       if ($request->ajax() || $request->wantsJson()) {
           $rules = [
               'barang_kode'  => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
               'barang_nama'  => 'required|string|max:100',
               'harga_beli'   => 'required|numeric',
               'harga_jual'   => 'required|numeric',
               'kategori_id'  => 'required|integer'
           ];

           $validator = Validator::make($request->all(), $rules);

           if ($validator->fails()) {
               return response()->json([
                   'status' => false, // respon json, true: berhasil, false: gagal
                   'message' => 'Validasi gagal.',
                   'msgField' => $validator->errors() // menunjukkan field mana yang error
               ]);
           }

           $barang = BarangModel::find($id);
           if ($barang) {
               $barang->update($request->all());
               return response()->json([
                   'status' => true,
                   'message' => 'Data barang berhasil diupdate'
               ]);
           } else {
               return response()->json([
                   'status' => false,
                   'message' => 'Data barang tidak ditemukan'
               ]);
           }
       }
       return redirect('/');
   }

   // Menampilkan halaman konfirmasi hapus user melalui AJAX
   public function confirm_ajax(string $id)
   {
       $barang = BarangModel::find($id);
       return view('barang.confirm_ajax', ['barang' => $barang]);
   }

   public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
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