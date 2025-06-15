<?php

use App\Http\Controllers\Penjualan;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    //penjualan Route
    Route::get('/dashboard/penjualan', [\App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/dashboard/penjualan/create', [\App\Http\Controllers\PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/dashboard/penjualan/{penjualan}', [\App\Http\Controllers\PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('/dashboard/penjualan/update/{penjualan}', [\App\Http\Controllers\PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/dashboard/penjualan/delete/{penjualan}', [\App\Http\Controllers\PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    //parameter Route
    Route::get('dashboard/parameter', [\App\Http\Controllers\ParameterController::class, 'index'])->name('parameter.index');
    Route::post('dashboard/parameter/create', [\App\Http\Controllers\ParameterController::class, 'store'])->name('parameter.store');
    Route::get('dashboard/parameter/{parameter}', [\App\Http\Controllers\ParameterController::class, 'edit'])->name('parameter.edit');
    Route::put('dashboard/parameter/update/{parameter}', [\App\Http\Controllers\ParameterController::class, 'update'])->name('parameter.update');
    Route::delete('dashboard/parameter/delete/{parameter}', [\App\Http\Controllers\ParameterController::class, 'destroy'])->name('parameter.destroy');
    //Forcasting Route
    Route::get('dashboard/forcasting', [\App\Http\Controllers\ForcastingController::class, 'index'])->name('forcasting.index');
    Route::post('dashboard/forcasting/create', [\App\Http\Controllers\ForcastingController::class, 'forecast'])->name('forcasting.create');
    Route::delete('dashboard/forcasting/delete/{id}', [\App\Http\Controllers\ForcastingController::class, 'destroy'])->name('forcasting.delete');

});

require __DIR__.'/auth.php';
