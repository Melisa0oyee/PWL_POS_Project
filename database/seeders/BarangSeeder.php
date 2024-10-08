<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Smartphone XYZ', 'harga_beli' => 2000000, 'harga_jual' => 2500000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Laptop ABC', 'harga_beli' => 5000000, 'harga_jual' => 6000000],
            ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'BRG003', 'barang_nama' => 'Headphone DEF', 'harga_beli' => 500000, 'harga_jual' => 700000],
            ['barang_id' => 4, 'kategori_id' => 1, 'barang_kode' => 'BRG004', 'barang_nama' => 'Smartwatch GHI', 'harga_beli' => 800000, 'harga_jual' => 1000000],
            ['barang_id' => 5, 'kategori_id' => 1, 'barang_kode' => 'BRG005', 'barang_nama' => 'Camera JKL', 'harga_beli' => 3500000, 'harga_jual' => 4000000],

            ['barang_id' => 6, 'kategori_id' => 2, 'barang_kode' => 'BRG006', 'barang_nama' => 'T-Shirt MNO', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['barang_id' => 7, 'kategori_id' => 2, 'barang_kode' => 'BRG007', 'barang_nama' => 'Jeans PQR', 'harga_beli' => 300000, 'harga_jual' => 350000],
            ['barang_id' => 8, 'kategori_id' => 2, 'barang_kode' => 'BRG008', 'barang_nama' => 'Jacket STU', 'harga_beli' => 500000, 'harga_jual' => 600000],
            ['barang_id' => 9, 'kategori_id' => 2, 'barang_kode' => 'BRG009', 'barang_nama' => 'Sneakers VWX', 'harga_beli' => 700000, 'harga_jual' => 900000],
            ['barang_id' => 10, 'kategori_id' => 2, 'barang_kode' => 'BRG010', 'barang_nama' => 'Hat YZA', 'harga_beli' => 100000, 'harga_jual' => 150000],

            ['barang_id' => 11, 'kategori_id' => 3, 'barang_kode' => 'BRG011', 'barang_nama' => 'Instant Noodles BCD', 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['barang_id' => 12, 'kategori_id' => 3, 'barang_kode' => 'BRG012', 'barang_nama' => 'Biscuit EFG', 'harga_beli' => 15000, 'harga_jual' => 20000],
            ['barang_id' => 13, 'kategori_id' => 3, 'barang_kode' => 'BRG013', 'barang_nama' => 'Coffee HIK', 'harga_beli' => 25000, 'harga_jual' => 30000],
            ['barang_id' => 14, 'kategori_id' => 3, 'barang_kode' => 'BRG014', 'barang_nama' => 'Cereal JKL', 'harga_beli' => 30000, 'harga_jual' => 35000],
            ['barang_id' => 15, 'kategori_id' => 3, 'barang_kode' => 'BRG015', 'barang_nama' => 'Juice MNO', 'harga_beli' => 20000, 'harga_jual' => 25000],
        ]);
    }
}
