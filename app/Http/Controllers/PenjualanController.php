<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use Yajra\DataTables\Facades\DataTables;
use function PHPUnit\Framework\isEmpty;

class PenjualanController extends Controller
{
    public function index(Request $request) : object
    {
        if ($request->ajax()) {
            $data = Penjualan::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return $row->id;
                })
                ->toJson();
        }

        return view('penjualan.index');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'total' => 'required|numeric',
            ]);

            $data = [
                'tanggal' => $validated['tanggal'],
                'total' => $validated['total'],
            ];

            Penjualan::create($data);

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
            $penjualan = Penjualan::find(intval($id));
            if (!isEmpty($penjualan)){
                return response()->json([
                    'success' => false,
                    'message' => 'Data penjualan tidak ditemukan',
                ]);
            }
            return response()->json([
                'success' => true,
                'data' => $penjualan,
            ]);

        }catch (\Exception $e) {
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
                'tanggal' => 'required|date',
                'total' => 'required|numeric',
            ]);
            $penjualan = Penjualan::find($id);
            if (!$penjualan){
                return response()->json([
                    'success' => false,
                    'message' => 'Data penjualan tidak ditemukan',
                ]);
            }
            $data = [
                'tanggal' => $validated['tanggal'],
                'total' => $validated['total'],
            ];
            $penjualan->update($data);
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
            $id = Penjualan::findOrFail($id);
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data penjualan tidak ditemukan',
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
