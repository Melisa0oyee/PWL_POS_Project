<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'KAT001', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'KAT002', 'kategori_nama' => 'Fashion'],
            ['kategori_id' => 3, 'kategori_kode' => 'KAT003', 'kategori_nama' => 'Makanan & Minuman'],
            ['kategori_id' => 4, 'kategori_kode' => 'KAT004', 'kategori_nama' => 'Perlengkapan Rumah'],
            ['kategori_id' => 5, 'kategori_kode' => 'KAT005', 'kategori_nama' => 'Kesehatan & Kecantikan'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
