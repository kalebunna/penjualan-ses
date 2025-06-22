<?php

namespace App\Http\Controllers;

use App\Models\ForcasResult;
use App\Models\Parameters;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $greeting = "Selamat Datang Kembali, " . $user->name . "!";

        $years = DB::table('penjualan')
            ->selectRaw('DISTINCT YEAR(tanggal) as year')
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year');
            
        $parameters = Parameters::orderBy('alpha')->get();
            
        return view('dashboard', compact('greeting', 'years', 'parameters'));
    }

    public function salesChartData(Request $request): JsonResponse
    {
        $year = $request->input('year', Carbon::now()->year);

        $salesData = DB::table('penjualan')
            ->selectRaw('MONTH(tanggal) as month, SUM(total) as total_sales')
            ->whereYear('tanggal', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthName = Carbon::create(null, $m)->locale('id')->monthName;
            $labels[] = $monthName;
            $sale = $salesData->firstWhere('month', $m);
            $data[] = $sale ? $sale->total_sales : 0;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function forecastChartData(Request $request): JsonResponse
    {
        $year = $request->input('year', Carbon::now()->year);
        $alpha_id = $request->input('alpha_id');

        if (!$alpha_id) {
            return response()->json(['message' => 'Silakan pilih nilai alpha untuk ditampilkan.'], 400);
        }
        
        $parameter = Parameters::find($alpha_id);
        if (!$parameter) {
            return response()->json(['message' => 'Parameter alpha tidak valid.'], 404);
        }

        $actualSales = DB::table('penjualan')
            ->selectRaw('MONTH(tanggal) as month, SUM(total) as total')
            ->whereYear('tanggal', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        if ($actualSales->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data penjualan untuk tahun yang dipilih.']);
        }

        $labels = $actualSales->map(function ($sale) use ($year) {
            return Carbon::createFromDate($year, $sale->month)->locale('id')->monthName;
        });

        $forecastData = ForcasResult::where('parameter_id', $parameter->id)
            ->whereYear('preode', $year)
            ->where('actual', '>', 0)
            ->orderBy('preode', 'asc')
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->preode)->month;
            });

        if ($forecastData->isEmpty()) {
            return response()->json([
                'message' => 'Data forecast untuk alpha ' . $parameter->alpha . ' di tahun ini belum tersedia. Silakan lakukan forecasting terlebih dahulu.'
            ], 404);
        }

        $forecast_values = $actualSales->map(function ($sale) use ($forecastData) {
            return $forecastData->get($sale->month)->forcas_result ?? null;
        });

        return response()->json([
            'labels' => $labels,
            'actuals' => $actualSales->pluck('total'),
            'forecasts' => $forecast_values,
            'alpha' => $parameter->alpha,
        ]);
    }
}
