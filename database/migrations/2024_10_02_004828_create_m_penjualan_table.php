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
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id'); // Primary Key penjualan_id
            $table->unsignedBigInteger('user_id'); // Foreign Key user_id mengacu ke tabel m_user
            $table->string('pembeli', 50); // Kolom pembeli dengan panjang maksimum 50 karakter
            $table->string('penjualan_kode', 20); // Kolom penjualan_kode dengan panjang maksimum 20 karakter
            $table->dateTime('penjualan_tanggal'); // Kolom penjualan_tanggal bertipe datetime
            $table->timestamps(); // Kolom created_at dan updated_at otomatis

            // Foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penjualan');
    }
};
