<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ParameterController extends Controller
{
    /**
     * @param Request $request
     * @return object|Factory|View|Application|JsonResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request): object
    {
        if ($request->ajax()) {
            $data = Parameters::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return $row->id;
                })
                ->toJson();
        }
        return view('parameter.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'alpha' => 'required|numeric|min:0|max:1',
            ]);
            $data = [
                'alpha' => $validated['alpha'],
            ];
            Parameters::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id): JsonResponse
    {
        try {
            $parameter = Parameters::find(intval($id));
            if (!$parameter){
                return response()->json([
                    'success' => false,
                    'message' => 'Data parameter tidak ditemukan',
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => $parameter,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'alpha' => 'required',
            ]);
            $parameter = Parameters::find($id);
            if (!$parameter){
                return response()->json([
                    'success' => false,
                    'message' => 'Data parameter tidak ditemukan',
                ]);
            }
            $data = [
                'alpha' => $validated['alpha'],
            ];
            $parameter->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $id = Parameters::findOrFail($id);
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data parameter tidak ditemukan',
                ]);
            }
            $id->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
}
