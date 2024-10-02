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
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id'); // Primary Key barang_id
            $table->unsignedBigInteger('kategori_id'); // Foreign Key kategori_id
            $table->string('barang_kode', 10); // Kolom barang_kode dengan panjang maksimum 10 karakter
            $table->string('barang_nama', 100); // Kolom barang_nama dengan panjang maksimum 100 karakter
            $table->integer('harga_beli'); // Kolom harga_beli tipe integer
            $table->integer('harga_jual'); // Kolom harga_jual tipe integer
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
