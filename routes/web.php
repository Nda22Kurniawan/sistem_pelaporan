<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SprinController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('sprin', SprinController::class);
    Route::patch('/sprin/{sprin}/update-status', [SprinController::class, 'updateStatus'])->name('sprin.update_status');

    Route::resource('users', UserController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::patch('/kegiatan/{kegiatan}/update-status', [KegiatanController::class, 'updateStatus'])->name('kegiatan.update-status');
    // Add other protected routes here...
});
