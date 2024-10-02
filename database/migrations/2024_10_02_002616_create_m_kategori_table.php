<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_kategori', function (Blueprint $table) {
            $table->id('kategori_id'); // Menggunakan kategori_id sebagai primary key
            $table->string('kategori_kode', 10); // Membuat kolom kategori_kode dengan panjang 10 karakter
            $table->string('kategori_nama', 100); // Membuat kolom kategori_nama dengan panjang 100 karakter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kategori');
    }
};
