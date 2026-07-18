<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NormaKerjaController;

Route::get('/', [NormaKerjaController::class, 'overview'])->name('dashboard');
Route::get('/master-norma', [NormaKerjaController::class, 'index'])->name('master.index');
Route::post('/master-norma', [NormaKerjaController::class, 'store'])->name('master.store');
Route::put('/master-norma/{id}', [NormaKerjaController::class, 'update'])->name('master.update');
Route::delete('/master-norma/{id}', [NormaKerjaController::class, 'destroy'])->name('master.destroy');
Route::post('/master-norma/import', [NormaKerjaController::class, 'import'])->name('master.import');
