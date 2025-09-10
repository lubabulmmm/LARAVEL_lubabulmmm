<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RumahSakitController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Route::resource('pasien', App\Http\Controllers\PasienController::class);
    Route::get('pasien', [App\Http\Controllers\PasienController::class, 'index'])->name('pasien.index');
    Route::get('pasien/rumahsakit/{id}', [App\Http\Controllers\PasienController::class, 'getByRumahSakit'])->name('pasien.getByRumahSakit');
    Route::post('pasien', [App\Http\Controllers\PasienController::class, 'store'])->name('pasien.store');
    Route::get('pasien/{id}/edit', [App\Http\Controllers\PasienController::class, 'edit'])->name('pasien.edit');
    Route::put('pasien/{id}', [App\Http\Controllers\PasienController::class, 'update'])->name('pasien.update');
    Route::delete('pasien/{id}', [App\Http\Controllers\PasienController::class, 'destroy'])->name('pasien.destroy');
    // Route::resource('rumahsakit', RumahSakitController::class);
    Route::get('rumahsakit', [RumahSakitController::class, 'index'])->name('rumahsakit.index');
    Route::post('rumahsakit', [RumahSakitController::class, 'store'])->name('rumahsakit.store');
    Route::get('rumahsakit/{id}/edit', [RumahSakitController::class, 'edit'])->name('rumahsakit.edit');
    Route::put('rumahsakit/{id}', [RumahSakitController::class, 'update'])->name('rumahsakit.update');
    Route::delete('rumahsakit/{id}', [RumahSakitController::class, 'destroy'])->name('rumahsakit.destroy');
});
