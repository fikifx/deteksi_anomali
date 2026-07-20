<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NormaKerjaController;
use App\Http\Controllers\AuthController;

// Public routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [NormaKerjaController::class, 'overview'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/master-norma', [NormaKerjaController::class, 'index'])->name('master.index');
    Route::post('/master-norma', [NormaKerjaController::class, 'store'])->name('master.store');
    Route::put('/master-norma/{id}', [NormaKerjaController::class, 'update'])->name('master.update');
    Route::delete('/master-norma/{id}', [NormaKerjaController::class, 'destroy'])->name('master.destroy');
    Route::post('/master-norma/import', [NormaKerjaController::class, 'import'])->name('master.import');
    Route::get('/master-norma/export', [NormaKerjaController::class, 'export'])->name('master.export');

    Route::get('/master-budget', [\App\Http\Controllers\MasterBudgetController::class, 'index'])->name('budget.index');
    Route::post('/master-budget', [\App\Http\Controllers\MasterBudgetController::class, 'store'])->name('budget.store');
    Route::put('/master-budget/{id}', [\App\Http\Controllers\MasterBudgetController::class, 'update'])->name('budget.update');
    Route::delete('/master-budget/{id}', [\App\Http\Controllers\MasterBudgetController::class, 'destroy'])->name('budget.destroy');

    Route::get('/norma-rawat', [\App\Http\Controllers\NormaRawatController::class, 'index'])->name('rawat.index');
    Route::post('/norma-rawat', [\App\Http\Controllers\NormaRawatController::class, 'store'])->name('rawat.store');
    Route::put('/norma-rawat/{id}', [\App\Http\Controllers\NormaRawatController::class, 'update'])->name('rawat.update');
    Route::delete('/norma-rawat/{id}', [\App\Http\Controllers\NormaRawatController::class, 'destroy'])->name('rawat.destroy');
    Route::post('/norma-rawat/import', [\App\Http\Controllers\NormaRawatController::class, 'import'])->name('rawat.import');
    Route::get('/norma-rawat/export', [\App\Http\Controllers\NormaRawatController::class, 'export'])->name('rawat.export');

    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'store'])->name('settings.store');
    
    Route::post('/telegram-users', [\App\Http\Controllers\TelegramUserController::class, 'store'])->name('telegram_users.store');
    Route::put('/telegram-users/{id}', [\App\Http\Controllers\TelegramUserController::class, 'update'])->name('telegram_users.update');
    Route::delete('/telegram-users/{id}', [\App\Http\Controllers\TelegramUserController::class, 'destroy'])->name('telegram_users.destroy');

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
});
