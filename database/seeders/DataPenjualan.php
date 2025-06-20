<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPenjualan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['bulan' => '01', 'tahun' => 2022, 'total' => 24735],
            ['bulan' => '02', 'tahun' => 2022, 'total' => 24750],
            ['bulan' => '03', 'tahun' => 2022, 'total' => 23490],
            ['bulan' => '04', 'tahun' => 2022, 'total' => 22430],
            ['bulan' => '05', 'tahun' => 2022, 'total' => 24960],
            ['bulan' => '06', 'tahun' => 2022, 'total' => 22650],
            ['bulan' => '07', 'tahun' => 2022, 'total' => 23405],
            ['bulan' => '08', 'tahun' => 2022, 'total' => 23870],
            ['bulan' => '09', 'tahun' => 2022, 'total' => 22890],
            ['bulan' => '10', 'tahun' => 2022, 'total' => 22680],
            ['bulan' => '11', 'tahun' => 2022, 'total' => 21418],
            ['bulan' => '12', 'tahun' => 2022, 'total' => 21401],
            ['bulan' => '01', 'tahun' => 2023, 'total' => 22800],
            ['bulan' => '02', 'tahun' => 2023, 'total' => 21960],
            ['bulan' => '03', 'tahun' => 2023, 'total' => 21200],
            ['bulan' => '04', 'tahun' => 2023, 'total' => 24900],
            ['bulan' => '05', 'tahun' => 2023, 'total' => 23940],
            ['bulan' => '06', 'tahun' => 2023, 'total' => 25265],
            ['bulan' => '07', 'tahun' => 2023, 'total' => 24360],
            ['bulan' => '08', 'tahun' => 2023, 'total' => 21930],
            ['bulan' => '09', 'tahun' => 2023, 'total' => 23190],
            ['bulan' => '10', 'tahun' => 2023, 'total' => 21480],
            ['bulan' => '11', 'tahun' => 2023, 'total' => 22860],
            ['bulan' => '12', 'tahun' => 2023, 'total' => 20593],
            ['bulan' => '01', 'tahun' => 2024, 'total' => 22355],
            ['bulan' => '02', 'tahun' => 2024, 'total' => 25237],
            ['bulan' => '03', 'tahun' => 2024, 'total' => 26230],
            ['bulan' => '04', 'tahun' => 2024, 'total' => 25221],
            ['bulan' => '05', 'tahun' => 2024, 'total' => 22605],
            ['bulan' => '06', 'tahun' => 2024, 'total' => 23600],
            ['bulan' => '07', 'tahun' => 2024, 'total' => 23345],
            ['bulan' => '08', 'tahun' => 2024, 'total' => 25220],
            ['bulan' => '09', 'tahun' => 2024, 'total' => 23321],
            ['bulan' => '10', 'tahun' => 2024, 'total' => 22600],
            ['bulan' => '11', 'tahun' => 2024, 'total' => 21977],
            ['bulan' => '12', 'tahun' => 2024, 'total' => 20401],
        ];

        foreach ($data as $item) {
            Penjualan::create([
                'tanggal' => Carbon::createFromDate($item['tahun'], $item['bulan'], 1)->toDateString(),
                'total' => $item['total'],
            ]);
        }
    }
}
