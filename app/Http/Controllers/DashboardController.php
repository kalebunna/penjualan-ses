<?php

namespace App\Http\Controllers;

use App\Models\ForcasResult;
use App\Models\Parameters;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $p = Parameters::all();

        //query untuk mengambil data penjualan bulan terakhir
        // $penjualan = DB::table('penjualan')
        //             ->selectRaw('To_char(tanggal, \'YYYY-MM\') AS bulan, SUM(total) AS total')
        //             ->groupByRaw('To_char(tanggal, \'YYYY-MM\')')
        //             ->orderByRaw('To_char(tanggal, \'YYYY-MM\')')
        //             ->get();

        //untuk menghitung total semua penjualan
        $totalPenjualan = Penjualan::sum('total');

        //untuk mengambil hasil prediksi terbaru
        $prediksiPenjualan = ForcasResult::select('preode', 'forcas_result')
            ->orderBy('preode', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        //MYSQL query
        $penjualan = DB::table('penjualan')
            ->selectRaw('DATE_FORMAT(tanggal, \'%Y-%m\') AS bulan, SUM(total) AS total')
            ->groupByRaw('DATE_FORMAT(tanggal, \'%Y-%m\')')
            ->orderByRaw('DATE_FORMAT(tanggal, \'%Y-%m\') DESC')
            ->limit(1)
            ->first();

        $totalParameters = count($p);

        $forcastCart = ForcasResult::with('parameter:id,alpha')
            ->select('preode', 'forcas_result', 'parameter_id')
            ->orderBy('updated_at', 'asc')
            ->orderBy('parameter_id', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return number_format($item->parameter->alpha, 1);
            })
            ->map(function ($group) {
                return $group->unique('preode')->values();
            });

        $series = [];
        //        dd($forcastCart);
        foreach ($forcastCart as $key => $value) {
            $series[] = [
                'name' => (string)$key,
                'data' => $value->pluck('forcas_result'),
            ];
        }
        //        dd($series);
        $categories = $forcastCart->first()->pluck('preode')->map(function ($item) {
            return date('Y-m', strtotime($item));
        });
        //        dd($categories);
        return view('dahsboard', compact('totalParameters', 'penjualan', 'totalPenjualan', 'prediksiPenjualan', 'categories', 'series', 'categories'));
    }
}
