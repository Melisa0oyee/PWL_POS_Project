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
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->id('supplier_id'); // Menggunakan supplier_id sebagai primary key
            $table->string('supplier_kode', 10); // Membuat kolom supplier_kode dengan panjang maksimum 10 karakter
            $table->string('supplier_nama', 100); // Membuat kolom supplier_nama dengan panjang maksimum 100 karakter
            $table->string('supplier_alamat', 255); // Membuat kolom supplier_alamat dengan panjang maksimum 255 karakter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_supplier');
    }
};
