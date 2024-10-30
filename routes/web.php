<?php


use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\HomeController;
use PharIo\Manifest\Author;

Route::pattern('id', '[0-9]+'); //artinya ketika ada parameter (id), maka harus berupa angka

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('register',[AuthController::class,'register']);
Route::post('register',[AuthController::class,'store']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [WelcomeController::class, 'index']);

    Route::middleware(['auth'])->group(function(){

        Route::get('/', [WelcomeController::class, 'index']);

        Route::middleware(['authorize:ADM'])->group(function(){
            Route::get('/user', [UserController::class, 'index']);  // menampilkan halaman user
            Route::get('/user/list', [UserController::class, 'list'] );    //menampilkan data user dalam bentuk json datatables
            Route::get('/user/create', [UserController::class, 'create']);  //menampilkan halaman tambah user
            Route::get('/user/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user Ajax
            Route::post('/user/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::post('/user', [UserController::class,'store']);      //menyimpan data user baru
            Route::get('/user/{id}', [UserController::class, 'show']);       //menampilkan detai user
            Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']);
            Route::get('/user/{id}/edit', [UserController::class, 'edit']);        //menampilkan halaman form user edit
            Route::put('/user/{id}', [UserController::class, 'update']);         //menyimpan perubahan data user
            Route::get('/user/{id}/edit_ajax', [UserController::class,'edit_ajax']); //menampilkan halaman form edit user ajax
            Route::put('/user/{id}/update_ajax', [UserController::class,'update_ajax']);   //menyimpan halaman form edit user ajax
            Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //tampil form confirm delete user ajax
            Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  //hapus data user
            Route::get('/user/import', [UserController::class, 'import']); //ajax form upload excel
            Route::post('/user/import_ajax', [UserController::class, 'import_ajax']); //ajax form upload excel
            Route::get('/user/export_excel', [UserController::class, 'export_excel']); //export_excel
            Route::get('/user/export_pdf', [UserController::class, 'export_pdf']); //export_pdf
            Route::delete('/user/{id}', [UserController::class, 'destroy']);     //mengahpus data user
            Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');

        });

        Route::middleware(['authorize:ADM,MNG,STF,PLG,CLT,CUS'])->group(function(){
            Route::get('/profil', [ProfilController::class, 'index']);
            Route::get('/profil/{id}/edit_ajax', [ProfilController::class, 'edit_ajax']);
            Route::put('/profil/{id}/update_ajax', [ProfilController::class, 'update_ajax']);
        });


// PROFIL
// Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
//     Route::get('/profile', [ProfileController::class, 'index']);
//     Route::get('/profile/{id}/edit_ajax', [ProfileController::class, 'edit_ajax']);
//     Route::put('/profile/{id}/update_ajax', [ProfileController::class, 'update_ajax']);
//     Route::get('/profile/{id}/edit_foto', [ProfileController::class, 'edit_foto']);
//     Route::put('/profile/{id}/update_foto', [ProfileController::class, 'update_foto']);
// });

//untuk M_LEVEL
Route::middleware(['authorize:ADM'])->group(function(){ //semua route harus punya role adm baru bisa akses
    Route::get('/level', [LevelController::class, 'index']); //menampilkan halaman awal leevel
    Route::get('/level/list',[LevelController::class,'list']);   //menampilkan data level dalam bentuk json
    Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
    Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']); //Menampilkan halaman form tambah user Ajax
    Route::post('/level/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::post('/level', [LevelController::class, 'store']);         // menyimpan data level baru
    // Route::get('/level/{id}', [LevelController::class, 'show']);
    Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
    Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::get('/level/{id}/edit_ajax', [LevelController::class,'edit_ajax']); //menampilkan halaman form edit user ajax
    Route::put('/level/{id}/update_ajax', [LevelController::class,'update_ajax']);   //menyimpan halaman form edit user ajax
    Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //tampil form confirm delete user ajax
    Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  //hapus data user
    Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']); // menampilkan detail level
    Route::get('/barang/{id}/show',[LevelController::class,'show']);
    Route::get('/level/import', [LevelController::class, 'import']); //ajax form upload excel
    Route::post('/level/import_ajax', [LevelController::class, 'import_ajax'])->name('user.import_ajax');; //ajax form upload excel
    Route::get('/level/export_excel', [LevelController::class, 'export_excel']); //export_excel
    Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); //export_pdf
    Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

// TABEL KATEGORI
Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
    Route::get('/kategori', [KategoriController::class, 'index']); //menampilkan halaman awal leevel
    Route::get('/kategori/list',[KategoriController::class,'list']);   //menampilkan data Kategori dalam bentuk json
    Route::get('/kategori/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah Kategori
    Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']); //Menampilkan halaman form tambah user Ajax
    Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::post('/kategori', [KategoriController::class, 'store']);         // menyimpan data Kategori baru
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit Kategori
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data Kategori
    Route::get('/kategori/{id}/edit_ajax', [KategoriController::class,'edit_ajax']); //menampilkan halaman form edit user ajax
    Route::put('/kategori/{id}/update_ajax', [KategoriController::class,'update_ajax']);   //menyimpan halaman form edit user ajax
    Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //tampil form confirm delete user ajax
    Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  //hapus data user
    Route::get('/kategori/{id}', [KategoriController::class, 'show']);       // menampilkan detail level
    Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
    Route::get('/kategori/import', [KategoriController::class, 'import']); //ajax form upload excel
    Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); //export_excel
    Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']); //export_pdf
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']); // menghapus data Kategori
});

// TABEL SUPPLIER
Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/supplier', [SupplierController::class, 'index']); //menampilkan halaman awal leevel
    Route::post('/supplier/list',[SupplierController::class,'list']);   //menampilkan data Supplier dalam bentuk json
    Route::get('/supplier/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah Supplier
    Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah supplier Ajax
    Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']); // menyimpan data supplier baru Ajax
    Route::post('/supplier', [SupplierController::class, 'store']);         // menyimpan data Supplier baru
    Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
    Route::put('/supplier/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data Supplier
    Route::get('/supplier/{id}/edit_ajax', [SupplierController::class,'edit_ajax']); //menampilkan halaman form edit user ajax
    Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data supplier Ajax
    Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete supplier Ajax
    Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // untuk hapus data supplier Ajax
    Route::get('/supplier/{id}', [SupplierController::class, 'show']);       // menampilkan detail level
    Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
    Route::get('/supplier/import', [SupplierController::class, 'import']); //ajax form upload excel
    Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']); //ajax form upload excel
    Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']); //export_excel
    Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']); //export_pdf
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
});

// TABEL BARANG
Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
    Route::get('/barang', [BarangController::class, 'index']); //menampilkan halaman awal leevel
    Route::post('/barang/list',[BarangController::class,'list']);   //menampilkan data Barang dalam bentuk json
    Route::get('/barang/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah Barang
    Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah barang Ajax
    Route::post('/barang/ajax', [BarangController::class, 'store_ajax']); // menyimpan data barang baru Ajax
    Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
    Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    Route::post('/barang', [BarangController::class, 'store']);         // menyimpan data Barang baru
    Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit barang Ajax
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit Barang
    Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data Barang
    Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data barang Ajax
    Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete barang Ajax
    Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // untuk hapus data barang Ajax
    Route::get('/barang/import', [BarangController::class, 'import']); //ajax form upload excel
    Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax'])->name('barang.import_ajax');; //ajax form upload excel
    Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); //export_excel
    Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); //export_pdf
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data Supplier
    Route::post('/barang/harga', [BarangController::class, 'getHargaBarang']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile'); // Tambahkan ini
});


// stok
Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function(){
    Route::get('/stok', [StokController::class, 'index']);  // menampilkan halaman stok
    Route::get('/stok/list', [StokController::class, 'list'] );    //menampilkan data stok dalam bentuk json datatables
    Route::get('/stok/create', [StokController::class, 'create']);
    Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']); //Menampilkan halaman form tambah stok Ajax
    Route::post('/stok/ajax', [StokController::class, 'store_ajax']); // Menyimpan data stok baru Ajax
    Route::get('/stok/{id}', [StokController::class, 'show']);       //menampilkan detai stok
    Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::get('/stok/{id}/edit_ajax', [StokController::class,'edit_ajax']); //menampilkan halaman form edit stok ajax
    Route::put('/stok/{id}/update_ajax', [StokController::class,'update_ajax']);   //menyimpan halaman form edit stok ajax
    Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); //tampil form confirm delete stok ajax
    Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);  //hapus data stok
    Route::delete('/stok/{id}', [StokController::class, 'destroy']);     //mengahpus data stok
    Route::get('/stok/import', [StokController::class, 'import']); //ajax form upolad
    Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']); //ajax import exvel)
    Route::get('/stok/export_excel', [StokController::class, 'export_excel']);  //export excel
    Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']); //export pdf
});
Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/penjualan/list', [PenjualanController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
        Route::get('/penjualan/create', [PenjualanController::class, 'create']);   // menampilkan halaman form tambah stok
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
        Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']);
        Route::post('/penjualan', [PenjualanController::class, 'store']);         // menyimpan data stok baru
        Route::get('/penjualan/import', [PenjualanController::class, 'import']);
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
        Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']); // export excel
        Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);       // menampilkan detail stok
        Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
        Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit']);  // menampilkan halaman form edit stok
        Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);     // menyimpan perubahan data stok
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']); // menghapus data stok
        
});
Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    Route::group(['prefix' => 'detail'], function () {
        Route::get('/', [DetailController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/list', [DetailController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
        Route::get('/create', [DetailController::class, 'create']);   // menampilkan halaman form tambah stok
        Route::get('/create_ajax', [DetailController::class, 'create_ajax']);
        Route::post('/ajax', [DetailController::class, 'store_ajax']);
        Route::post('/', [DetailController::class, 'store']);         // menyimpan data stok baru
        Route::get('/import', [DetailController::class, 'import']);
        Route::post('/import_ajax', [DetailController::class, 'import_ajax']);
        Route::get('/export_excel', [DetailController::class, 'export_excel']); // export excel
        Route::get('/export_pdf', [DetailController::class, 'export_pdf']); // export pdf
        Route::get('/{id}', [DetailController::class, 'show']);       // menampilkan detail stok
        Route::get('/penjualan/detail/{id}/show_ajax', [DetailController::class, 'show_ajax']);
        Route::get('/{id}/edit', [DetailController::class, 'edit']);  // menampilkan halaman form edit stok
        Route::put('/{id}', [DetailController::class, 'update']);     // menyimpan perubahan data stok
        Route::get('/penjualan/detail/{id}/edit_ajax', [DetailController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [DetailController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [DetailController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [DetailController::class, 'delete_ajax']);
        Route::delete('/{id}', [DetailController::class, 'destroy']); // menghapus data stok
    });
});
});
});

?>