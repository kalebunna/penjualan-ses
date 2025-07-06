<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use Yajra\DataTables\Facades\DataTables;
use function PHPUnit\Framework\isEmpty;
use Carbon\Carbon;

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

            // Check if data for the same month and year already exists
            $inputDate = Carbon::parse($validated['tanggal']);
            $existingRecord = Penjualan::whereYear('tanggal', $inputDate->year)
                ->whereMonth('tanggal', $inputDate->month)
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data untuk bulan ' . $inputDate->format('F Y') . ' sudah ada. Silakan pilih bulan lain atau edit data yang sudah ada.',
                ], 422);
            }

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

            // Check if data for the same month and year already exists (excluding current record)
            $inputDate = Carbon::parse($validated['tanggal']);
            $existingRecord = Penjualan::whereYear('tanggal', $inputDate->year)
                ->whereMonth('tanggal', $inputDate->month)
                ->where('id', '!=', $id)
                ->first();

            if ($existingRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data untuk bulan ' . $inputDate->format('F Y') . ' sudah ada. Silakan pilih bulan lain.',
                ], 422);
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
