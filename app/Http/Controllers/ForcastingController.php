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
                    ->addColumn('action', function($row){
                        return $row->id;
                    })
                    ->toJson();
            }
            $parameters = Parameters::all();
            return view('forcasting.index', compact('parameters'));
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
//       $penjualan = DB::table("penjualan")
//           ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(total) AS total")
//           ->groupByRaw("DATE_FORMAT(tanggal, '%Y-%m')")
//           ->orderByRaw("DATE_FORMAT(tanggal, '%Y-%m')")
//           ->get();

        $penjualan = DB::table("penjualan")
            ->selectRaw("To_char(tanggal, 'YYYY-MM') AS bulan, SUM(total) AS total")
            ->groupByRaw("To_char(tanggal, 'YYYY-MM')")
            ->orderByRaw("To_char(tanggal, 'YYYY-MM')")
            ->get();

        $aktual = [];
        for ($i = 0; $i < count($penjualan); $i++) {
            $aktual[$i] = $penjualan[$i]->total;
        }

        $forcasing_result = $this->sesService->singleExponentialSmoothing($parameter->alpha, $aktual); //Proses Single Exponential Smoothing
        $MAD = $this->sesService->meanAbsoluteDeviation($aktual, $forcasing_result); //Proses Mean Absolute Deviation
        $MAPE = $this->sesService->meanAbsolutePercentageError($aktual, $forcasing_result); //Proses Mean Absolute Percentage Error
        $MSE = $this->sesService->meanSquaredError($aktual, $forcasing_result); //Proses Mean Squared Error
//
        ForcasResult::create([
            'parameter_id' => $parameter->id,
            'alpha' => $parameter->alpha,
            'forcas_result' => $forcasing_result[count($forcasing_result) - 1],
            'actual' => 0,
            'MAD' => $MAD,
            'MAP' => $MAPE,
            'MSE' => $MSE,
            'err' => 0,
            'preode' => Carbon::parse($penjualan->last()->bulan)->addMonth()->format('Y-m-d'),
        ]);
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
}
