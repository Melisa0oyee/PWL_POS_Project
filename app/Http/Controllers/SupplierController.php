<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StokModel;


class SupplierController extends Controller
{
    // Menampilkan halaman awal supplier
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list'  => ['Home', 'Supplier']
        ];
        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];
        $activeMenu = 'supplier'; // set menu yang sedang aktif
        $supplier = SupplierModel::all();
        return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
    }
    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Ambil data supplier
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');


        // Return data untuk DataTables
        return DataTables::of($suppliers)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($supplier) {
                // Menambahkan kolom aksi untuk edit, detail, dan hapus
                // $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                
                $btn = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;

            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }
    // Menampilkan halaman form tambah supplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list'  => ['Home', 'Supplier', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];
        $activeMenu = 'supplier'; // set menu yang sedang aktif
        return view('supplier.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }
    // Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode', // Kode harus unik
            'supplier_nama' => 'required|string|max:100', // Nama harus diisi
            'supplier_alamat' => 'required|string|max:255', // Alamat harus diisi
        ]);

        SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat, // Jangan lupa menyimpan alamat
        ]);
    
        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    // Menampilkan detail supplier
    public function show(string $id)
    {
        $supplier = SupplierModel::find($id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Supplier tidak ditemukan');
        }
        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list'  => ['Home', 'Supplier', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail supplier'
        ];
        $activeMenu = 'supplier'; // set menu yang sedang aktif
        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit supplier
    public function edit(string $id)
    {
        $supplier = SupplierModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list'  => ['Home', 'Supplier', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit supplier'
        ];
        $activeMenu = 'supplier'; // set menu yang sedang aktif
        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }
    // Menyimpan perubahan data supplier
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,'.$id.',supplier_id',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255',
        ]);
        SupplierModel::find($id)->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);
        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }
    // Menghapus data supplier
    public function destroy(string $id)
    {
        $check = SupplierModel::find($id);
        if (!$check) {  
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }
        try {
            SupplierModel::destroy($id); 
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        return view('supplier.create_ajax')->with('supplier', $supplier);
    }

    // Menyimpan data supplier baru melalui ajax
    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_kode' => 'required|string|unique:m_supplier,supplier_kode',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255', // Tambahkan validasi untuk alamat
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors(),
                'message' => 'Validasi gagal, periksa input Anda.'
            ]);
        }

        try {
            SupplierModel::create([
                'supplier_kode' => $request->supplier_kode,
                'supplier_nama' => $request->supplier_nama,
                'supplier_alamat' => $request->supplier_alamat, // Pastikan menyimpan alamat supplier
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ]);
        }
    }

    public function edit_ajax(string $id)
    {
        // Mengambil data supplier berdasarkan ID
        $supplier = SupplierModel::find($id);
        if (!$supplier) {
            return response()->json([
                'status' => false,
                'message' => 'Supplier tidak ditemukan',
            ]);
        }
        return view('supplier.edit_ajax', compact('supplier')); // Mengembalikan view untuk edit
    }

    // Mengupdate data supplier melalui ajax
    public function update_ajax(Request $request, string $id)
    {
        // Cek apakah request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id' => 'required|integer',
                'supplier_kode' => 'required|string|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                'supplier_nama' => 'required|string|max:100',
                'supplier_alamat' => 'nullable|string|max:255', // Tambahkan aturan untuk alamat
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

            // Cek apakah supplier ada
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                // Update data supplier
                $supplier->update($request->only(['supplier_kode', 'supplier_nama', 'supplier_alamat']));

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

    // Fungsi confirm_ajax()
    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    // Fungsi delete_ajax()
    public function delete_ajax(Request $request, $id)
    {
        // Cek apakah request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024'], // pastikan file xlsx dan ukuran tidak lebih dari 1MB
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_supplier');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'supplier_id'    => $value['A'],
                            'supplier_kode'  => $value['B'],
                            'supplier_nama'  => $value['C'],
                            'supplier_alamat' => $value['D'],
                            'created_at'     => now(),
                        ];
                    }
                }
            }

            if (count($insert) > 0) {
                SupplierModel::insertOrIgnore($insert);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diimport'
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Tidak ada data yang diimport'
        ]);
    }

    public function export_excel()
    {
        // ambil data barang yang akan di export
        $level = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->get();
            
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Kode Supplier');
        $sheet->setCellValue('C1', 'Nama Supplier');
        $sheet->setCellValue('D1', 'Alamat Supplier');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header
        $supplier_id = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($level as $key => $value) {
            $sheet->setCellValue('A' . $baris, $supplier_id);
            $sheet->setCellValue('B' . $baris, $value->supplier_kode);
            $sheet->setCellValue('C' . $baris, $value->supplier_nama);
            $sheet->setCellValue('D' . $baris, $value->supplier_alamat);
            $baris++;
            $supplier_id++;
        }
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data Supplier'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Supplier ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->get();

        // Ambil data stok barang
        $stokBarang = StokModel::with(['supplier', 'barang', 'user'])->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('supplier.export_pdf', [
            'supplier' => $supplier,
            'stokBarang' => $stokBarang // Pastikan ini dikirim ke tampilan
        ]);

        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data Supplier' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function show_ajax(String $id){
        $supplier = SupplierModel::find($id);
    
        if (!$supplier){
            return response()->json([
                'status' => false,
                'message' => 'Data supplier tidak ditemukan'
            ]);
        }
    
        return view('supplier.show_ajax', ['user' => $supplier]);
    }
}