<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            ['supplier_id' => 1, 'supplier_kode' => 'SUP001', 'supplier_nama' => 'PT Elektronik Jaya', 
            'supplier_alamat' => 'Jl. Sudirman No. 45, Jakarta'],
            ['supplier_id' => 2, 'supplier_kode' => 'SUP002', 'supplier_nama' => 'CV Fashionista', 
            'supplier_alamat' => 'Jl. Melati No. 23, Bandung'],
            ['supplier_id' => 3, 'supplier_kode' => 'SUP003', 'supplier_nama' => 'UD Makanan Nusantara', 
            'supplier_alamat' => 'Jl. Mangga Dua No. 10, Surabaya'],
        ]);
    }
}
