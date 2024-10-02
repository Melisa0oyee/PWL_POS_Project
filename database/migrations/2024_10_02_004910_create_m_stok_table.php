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
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id'); // Primary Key stok_id
            $table->unsignedBigInteger('supplier_id'); // Foreign Key supplier_id mengacu ke tabel m_supplier
            $table->unsignedBigInteger('barang_id'); // Foreign Key barang_id mengacu ke tabel m_barang
            $table->unsignedBigInteger('user_id'); // Foreign Key user_id mengacu ke tabel m_user
            $table->dateTime('stok_tanggal'); // Kolom stok_tanggal untuk menyimpan tanggal stok
            $table->integer('stok_jumlah'); // Kolom stok_jumlah untuk menyimpan jumlah stok
            $table->timestamps(); // Menyimpan waktu pembuatan dan pembaruan otomatis

            // Foreign key constraints
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stok');
    }
};
