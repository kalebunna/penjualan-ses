<?php

namespace App\Http\Controllers;

use App\Models\ForcasResult;
use App\Models\Parameters;
use App\Service\SesService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ForcastingController extends Controller
{
    private $sesService;

    public function __construct(SesService $sesService)
    {
        $this->sesService = $sesService;
    }

    /**
     * @param Request $request
     * @return object|Factory|View|Application|JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request): object
    {
        try {
            if ($request->ajax()) {
                $forcas_result = ForcasResult::with('parameter')->get();
                if ($request->has('parameter') && $request->parameter != null) {
                    $forcas_result = $forcas_result->where('parameter_id', $request->parameter);
                }
                return DataTables::of($forcas_result)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return $row->id;
                    })
                    ->toJson();
            }
            
            $parameters = Parameters::all();
            
            // Get next month prediction data
            $nextMonthPrediction = null;
            $forecastStatus = null;
            
            if ($request->has('parameter') && $request->parameter != null && $request->parameter != '') {
                $parameter = Parameters::find($request->parameter);
                if ($parameter) {
                    // Check if forecasting data exists for this parameter
                    $existingForecast = ForcasResult::where('parameter_id', $parameter->id)->first();
                    
                    if ($existingForecast) {
                        // Get sales data for calculation
                        $penjualan = DB::table("penjualan")
                            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(total) AS total")
                            ->groupByRaw("DATE_FORMAT(tanggal, '%Y-%m')")
                            ->orderByRaw("DATE_FORMAT(tanggal, '%Y-%m')")
                            ->get();

                        if (count($penjualan) > 0) {
                            $aktual = [];
                            for ($i = 0; $i < count($penjualan); $i++) {
                                $aktual[$i] = $penjualan[$i]->total;
                            }

                            // Use the same calculation logic as forecast method
                            $forcasing_result = $this->sesService->singleExponentialSmoothing($parameter->alpha, $aktual);
                            $nextMonthValue = $this->sesService->singleExponentialSmoothing($parameter->alpha, $aktual, true);
                            $madNextPeriod = $this->sesService->meanAbsoluteDeviation($aktual, $forcasing_result, true);
                            $mapeNextPeriod = $this->sesService->meanAbsolutePercentageError($aktual, $forcasing_result, true);
                            $mseNextPeriod = $this->sesService->meanSquaredError($aktual, $forcasing_result, true);

                            $nextMonthPrediction = [
                                'month' => Carbon::parse($penjualan[count($penjualan) - 1]->bulan)->endOfMonth()->addMonth()->format('Y-m-d'),
                                'prediction' => round($nextMonthValue, 2),
                                'MAD' => round($madNextPeriod, 2),
                                'MAPE' => round($mapeNextPeriod, 2),
                                'MSE' => round($mseNextPeriod, 2),
                                'parameter' => $parameter->alpha
                            ];
                        }
                    } else {
                        $forecastStatus = [
                            'message' => 'Data belum di-forecast untuk parameter ' . $parameter->alpha,
                            'parameter' => $parameter->alpha
                        ];
                    }
                }
            }
            
            return view('forcasting.index', compact('parameters', 'nextMonthPrediction', 'forecastStatus'));
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "errors" => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forecast(Request $request): JsonResponse
    {
        try {
            $validated = Validator::make($request->all(), [
                'id_parameter' => 'required',
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "success" => false,
                    "errors" => $validated->errors()
                ]);
            }

            $parameter = Parameters::find($request->id_parameter);

            //        Query Untuk mengambil data penjualan per bulan (MYSQL) jika menggunakan mysql
            $penjualan = DB::table("penjualan")
                ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(total) AS total")
                ->groupByRaw("DATE_FORMAT(tanggal, '%Y-%m')")
                ->orderByRaw("DATE_FORMAT(tanggal, '%Y-%m')")
                ->get();

            // $penjualan = DB::table("penjualan")
            //     ->selectRaw("To_char(tanggal, 'YYYY-MM') AS bulan, SUM(total) AS total")
            //     ->groupByRaw("To_char(tanggal, 'YYYY-MM')")
            //     ->orderByRaw("To_char(tanggal, 'YYYY-MM')")
            //     ->get();

            $aktual = [];
            for ($i = 0; $i < count($penjualan); $i++) {
                $aktual[$i] = $penjualan[$i]->total;
            }

            $forcasing_result = $this->sesService->singleExponentialSmoothing($parameter->alpha, $aktual); //Proses Single Exponential Smoothing dengan inisialisasi rata-rata
            $MAD = $this->sesService->meanAbsoluteDeviation($aktual, $forcasing_result); //Proses Mean Absolute Deviation
            $MAPE = $this->sesService->meanAbsolutePercentageError($aktual, $forcasing_result); //Proses Mean Absolute Percentage Error
            $MSE = $this->sesService->meanSquaredError($aktual, $forcasing_result); //Proses Mean Squared Error

            // Get next month prediction
            $nextMonthValue = $this->sesService->singleExponentialSmoothing($parameter->alpha, $aktual, true);
            
            $madNextPeriod = $this->sesService->meanAbsoluteDeviation($aktual, $forcasing_result, true); //Proses Mean Absolute Deviation untuk bulan yang akan mendatang
            $mapeNextPeriod = $this->sesService->meanAbsolutePercentageError($aktual, $forcasing_result, true); //Proses Mean Absolute Percentage Error untuk bulan yang akan mendatang
            $mseNextPeriod = $this->sesService->meanSquaredError($aktual, $forcasing_result, true); //Proses Mean Squared Error untuk bulan yang akan mendatang
            $data = [];
            for ($i = 0; $i < count($aktual); $i++) {
                $data[$i] = [
                    'preode' => Carbon::parse($penjualan[$i]->bulan)->endOfMonth()->format('Y-m-d'),
                    'actual' => $penjualan[$i]->total,
                    'forcas_result' => $forcasing_result[$i],
                    'MAD' => round($MAD[$i], 2),
                    'MAP' => round($MAPE[$i], 2),
                    'err' => round($penjualan[$i]->total - $forcasing_result[$i], 2),
                    'MSE' => round($MSE[$i], 2),
                    'parameter_id' => $parameter->id,
                ];
            }
            $data[] = [
                'preode' => Carbon::parse($penjualan[count($penjualan) - 1]->bulan)->endOfMonth()->addMonth()->format('Y-m-d'),
                'actual' => 0,
                'forcas_result' => $nextMonthValue,
                'MAD' => round($madNextPeriod, 2),
                'MAP' => round($mapeNextPeriod, 2),
                'err' => 0,
                'MSE' => round($mseNextPeriod, 2),
                'parameter_id' => $parameter->id,
            ];
            foreach ($data as $d) {
                ForcasResult::updateOrCreate(
                    [
                        'preode' => $d['preode'],
                        'parameter_id' => $d['parameter_id'],
                    ],
                    $d
                );
            }
            return response()->json([
                "success" => true,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "errors" => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            ForcasResult::find($id)->delete();
            return response()->json([
                "success" => true,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "errors" => $exception->getMessage()
            ]);
        }
    }

    public function bestAlpha()
    {
        try {
            $parameters = Parameters::all();
            $alpha_results = [];
            $best_alpha = null;
            $min_mse = PHP_FLOAT_MAX;

            foreach ($parameters as $parameter) {
                // Find the result for the next period prediction, which holds the summary metrics.
                $result = ForcasResult::where('parameter_id', $parameter->id)
                                      ->where('actual', 0)
                                      ->first();

                $mse = null;
                $mad = null;
                $mape = null;
                $status = 'Belum di-forecast';

                if ($result) {
                    $mse = $result->MSE;
                    $mad = $result->MAD;
                    $mape = $result->MAP;
                    $status = 'Sudah di-forecast';
                    if ($mse < $min_mse) {
                        $min_mse = $mse;
                        $best_alpha = [
                            'alpha' => $parameter->alpha,
                            'mse' => $mse,
                            'mad' => $mad,
                            'mape' => $mape
                        ];
                    }
                }

                $alpha_results[] = [
                    'alpha' => $parameter->alpha,
                    'mse' => $mse,
                    'mad' => $mad,
                    'mape' => $mape,
                    'status' => $status
                ];
            }

            // Sort results by alpha value
            usort($alpha_results, function($a, $b) {
                return $a['alpha'] <=> $b['alpha'];
            });

            return view('forcasting.best_alpha', compact('alpha_results', 'best_alpha'));

        } catch (\Exception $exception) {
            // Handle exceptions, maybe redirect back with an error
            return redirect()->route('forcasting.index')->with('error', $exception->getMessage());
        }
    }
}
