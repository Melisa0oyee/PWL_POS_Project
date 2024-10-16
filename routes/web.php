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
Route::group(['prefix' => 'user'], function() {
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
Route::middleware(['authorize:ADM,'])->group (function () {
    Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
    Route::post('/level/list', [LevelController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
    Route::post('/level', [LevelController::class, 'store']);         // menyimpan data level baru
    Route::get('/level/{id}', [LevelController::class, 'show']);       // menampilkan detail level
    Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
    Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

// TABEL KATEGORI
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);         // menyimpan data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
});

// TABEL SUPPLIER
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);         // menyimpan data supplier baru
    Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});

// TABEL BARANG
// Route::group(['prefix' => 'barang'], function () 
Route::middleware(['authorize:ADM,MNG'])->group (function (){
    Route::get('/barang', [BarangController::class, 'index']);              // menampilkan halaman awal user
    Route::post('/barang/list', [BarangController::class, 'list']);          // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/barang/create', [BarangController::class, 'create']);       // menampilkan halaman form tambah user
    Route::post('/barang', [BarangController::class, 'store']);             // menyimpan data user baru
    Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah user Ajax
    Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);         // menyimpan data user baru Ajax
    Route::get('/barang/{id}', [BarangController::class, 'show']);           // menampilkan detail user
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);      // menampilkan halaman form edit user
    Route::put('/barang/{id}', [BarangController::class, 'update']);         // menyimpan perubahan data user
    Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
    Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
    Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax 
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);     // menghapus data user
    Route::get('/barang/import', [BarangController::class, 'import']);       // ajax form upload excel
    Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
    Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // export excel
});

});
?>
