<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan')->insert([
            ['penjualan_id' => 1, 'user_id' => 1, 'pembeli' => 'John Doe', 'penjualan_kode' => 'PNJ001', 'penjualan_tanggal' => '2024-09-01 10:30:00'],
            ['penjualan_id' => 2, 'user_id' => 1, 'pembeli' => 'Jane Smith', 'penjualan_kode' => 'PNJ002', 'penjualan_tanggal' => '2024-09-02 11:15:00'],
            ['penjualan_id' => 3, 'user_id' => 2, 'pembeli' => 'Alice Johnson', 'penjualan_kode' => 'PNJ003', 'penjualan_tanggal' => '2024-09-03 12:00:00'],
            ['penjualan_id' => 4, 'user_id' => 2, 'pembeli' => 'Bob Brown', 'penjualan_kode' => 'PNJ004', 'penjualan_tanggal' => '2024-09-04 13:45:00'],
            ['penjualan_id' => 5, 'user_id' => 3, 'pembeli' => 'Charlie Davis', 'penjualan_kode' => 'PNJ005', 'penjualan_tanggal' => '2024-09-05 14:30:00'],

            ['penjualan_id' => 6, 'user_id' => 3, 'pembeli' => 'Emily Clark', 'penjualan_kode' => 'PNJ006', 'penjualan_tanggal' => '2024-09-06 15:00:00'],
            ['penjualan_id' => 7, 'user_id' => 1, 'pembeli' => 'David Evans', 'penjualan_kode' => 'PNJ007', 'penjualan_tanggal' => '2024-09-07 16:20:00'],
            ['penjualan_id' => 8, 'user_id' => 2, 'pembeli' => 'Sophia Green', 'penjualan_kode' => 'PNJ008', 'penjualan_tanggal' => '2024-09-08 17:10:00'],
            ['penjualan_id' => 9, 'user_id' => 3, 'pembeli' => 'James Harris', 'penjualan_kode' => 'PNJ009', 'penjualan_tanggal' => '2024-09-09 18:05:00'],
            ['penjualan_id' => 10, 'user_id' => 1, 'pembeli' => 'Olivia King', 'penjualan_kode' => 'PNJ010', 'penjualan_tanggal' => '2024-09-10 19:00:00'],
        ]);
    }
}
