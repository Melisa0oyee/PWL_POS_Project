<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function() { // Semua route di bawah ini membutuhkan autentikasi

Route:: get('/', [WelcomeController::class, 'index']);

// TABEL USER
// Route::group(['prefix' => 'user'], function() {
Route::middleware(['authorize:ADM'])->group(function() {
    Route::get('/', [UserController::class, 'index']);              // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);          // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);       // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);             // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);         // menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']);           // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);      // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);         // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax 
    Route::delete('/{id}', [UserController::class, 'destroy']);     // menghapus data user
});

// TABEL LEVEL
Route::group(['prefix' => 'level'], function() {
//Route::middleware(['authorize:ADM'])->group(function(){
    Route::get('/', [LevelController::class, 'index']);                // menampilkan halaman awal level
    Route::get('/list', [LevelController::class, 'list']);            // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);         // menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);               // menyimpan data level baru
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan halaman form tambah level Ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']);         // menyimpan data level baru Ajax
    Route::get('/{id}', [LevelController::class, 'show']);              // menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);        // menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);           // menyimpan perubahan data level
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // menampilkan halaman form edit level Ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data level Ajax
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
    Route::delete('/{id}', [LevelController::class, 'destroy']);       // menghapus data level
});


// TABEL KATEGORI
Route::group(['prefix' => 'kategori'], function() {
    Route::get('/', [KategoriController::class, 'index']);                            // menampilkan halaman awal kategori
    Route::get('/list', [KategoriController::class, 'list']);                        // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);                     // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);                           // menyimpan data kategori baru
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);           // menampilkan halaman form tambah kategori Ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);                  // menyimpan data kategori baru Ajax
    Route::get('/{id}', [KategoriController::class, 'show']);                         // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);                    // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);                       // menyimpan perubahan data kategori
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);          // menampilkan halaman form edit kategori Ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);      // menyimpan perubahan data kategori Ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);     // Untuk tampilkan form konfirmasi hapus kategori Ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  // Untuk hapus data kategori Ajax
    Route::delete('/{id}', [KategoriController::class, 'destroy']);                   // menghapus data kategori
});


// TABEL SUPPLIER
Route::group(['prefix' => 'supplier'], function() {
    Route::get('/', [SupplierController::class, 'index']);                            // menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);                         // menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);                     // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);                           // menyimpan data supplier baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);           // menampilkan halaman form tambah supplier Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);                  // menyimpan data supplier baru Ajax
    Route::get('/{id}', [SupplierController::class, 'show']);                         // menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);                    // menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);                       // menyimpan perubahan data supplier
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);          // menampilkan halaman form edit supplier Ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);      // menyimpan perubahan data supplier Ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);     // Untuk tampilkan form konfirmasi hapus supplier Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);   // Untuk hapus data supplier Ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']);                   // menghapus data supplier
});


// TABEL BARANG
Route::group(['prefix' => 'barang'], function (){
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal user
        Route::post('/list', [BarangController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah user
        Route::post('/', [BarangController::class, 'store']); // menyimpan data user baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [BarangController::class, 'store_ajax'])->name('barang.ajax'); // menyimpan data user baru Ajax
        Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show'); // menampilkan detail user  
        Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit user
        Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax 
        Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data user
        Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [BarangController::class, 'export_excel']); // export excel
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']); // export pdf
        });

    });
 });
?>