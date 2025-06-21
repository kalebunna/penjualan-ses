<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['bulan' => 'Januari', 'tahun' => 2022, 'penjualan' => 24735],
            ['bulan' => 'Februari', 'tahun' => 2022, 'penjualan' => 24750],
            ['bulan' => 'Maret', 'tahun' => 2022, 'penjualan' => 23490],
            ['bulan' => 'April', 'tahun' => 2022, 'penjualan' => 22430],
            ['bulan' => 'Mei', 'tahun' => 2022, 'penjualan' => 24960],
            ['bulan' => 'Juni', 'tahun' => 2022, 'penjualan' => 22650],
            ['bulan' => 'Juli', 'tahun' => 2022, 'penjualan' => 23405],
            ['bulan' => 'Agustus', 'tahun' => 2022, 'penjualan' => 23870],
            ['bulan' => 'September', 'tahun' => 2022, 'penjualan' => 22890],
            ['bulan' => 'Oktober', 'tahun' => 2022, 'penjualan' => 22680],
            ['bulan' => 'November', 'tahun' => 2022, 'penjualan' => 21418],
            ['bulan' => 'Desember', 'tahun' => 2022, 'penjualan' => 21401],
            ['bulan' => 'Januari', 'tahun' => 2023, 'penjualan' => 22800],
            ['bulan' => 'Februari', 'tahun' => 2023, 'penjualan' => 21960],
            ['bulan' => 'Maret', 'tahun' => 2023, 'penjualan' => 21200],
            ['bulan' => 'April', 'tahun' => 2023, 'penjualan' => 24900],
            ['bulan' => 'Mei', 'tahun' => 2023, 'penjualan' => 23940],
            ['bulan' => 'Juni', 'tahun' => 2023, 'penjualan' => 25265],
            ['bulan' => 'Juli', 'tahun' => 2023, 'penjualan' => 24360],
            ['bulan' => 'Agustus', 'tahun' => 2023, 'penjualan' => 21930],
            ['bulan' => 'September', 'tahun' => 2023, 'penjualan' => 23190],
            ['bulan' => 'Oktober', 'tahun' => 2023, 'penjualan' => 21480],
            ['bulan' => 'November', 'tahun' => 2023, 'penjualan' => 22860],
            ['bulan' => 'Desember', 'tahun' => 2023, 'penjualan' => 20593],
            ['bulan' => 'Januari', 'tahun' => 2024, 'penjualan' => 22355],
            ['bulan' => 'Februari', 'tahun' => 2024, 'penjualan' => 25237],
            ['bulan' => 'Maret', 'tahun' => 2024, 'penjualan' => 26230],
            ['bulan' => 'April', 'tahun' => 2024, 'penjualan' => 25221],
            ['bulan' => 'Mei', 'tahun' => 2024, 'penjualan' => 22605],
            ['bulan' => 'Juni', 'tahun' => 2024, 'penjualan' => 23600],
            ['bulan' => 'Juli', 'tahun' => 2024, 'penjualan' => 23345],
            ['bulan' => 'Agustus', 'tahun' => 2024, 'penjualan' => 25220],
            ['bulan' => 'September', 'tahun' => 2024, 'penjualan' => 23321],
            ['bulan' => 'Oktober', 'tahun' => 2024, 'penjualan' => 22600],
            ['bulan' => 'November', 'tahun' => 2024, 'penjualan' => 21977],
            ['bulan' => 'Desember', 'tahun' => 2024, 'penjualan' => 20401],
        ];
        $bulanIndoToEng = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        foreach ($data as $item) {
            $bulanEng = $bulanIndoToEng[$item['bulan']];
            $tanggal = Carbon::createFromFormat('d F Y', '01 ' . $bulanEng . ' ' . $item['tahun'])->format('Y-m-d');

            DB::table('penjualan')->insert([
                'tanggal' => $tanggal,
                'total' => $item['penjualan']
            ]);
        }
    }
}
