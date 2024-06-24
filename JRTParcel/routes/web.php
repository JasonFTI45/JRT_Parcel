<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// butuh login untuk akses route dibawah
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');    
});
// admin only routes
Route::middleware('isAdmin')->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::get('/karyawan/edit/{karyawan}', [KaryawanController::class, 'edit'])->name('karyawan.edit');

    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::patch('/karyawan/update/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/delete/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{resi}/print', [HistoryController::class, 'print'])->name('history.print');
});

// karyawan only routes
Route::middleware('isKaryawan')->group(function () {
    Route::get('/resi', [ResiController::class, 'index'])->name('resi.index');
    Route::get('/resi/create', [ResiController::class, 'create'])->name('resi.create');
    Route::post('/resi', [ResiController::class, 'store'])->name('resi.store');
    Route::get('/resi/{resi}', [ResiController::class, 'details'])->name('resi.details');
    Route::get('/resi/{resi}/edit', [ResiController::class, 'edit'])->name('resi.edit');
    Route::put('/resi/{resi}/update', [ResiController::class, 'update'])->name('resi.update');
    Route::post('/calculate-harga', [ResiController::class, 'calculateHargaAjax'])->name('calculate.harga');
    Route::get('/resi/{resi}/print', [ResiController::class, 'generatePdf'])->name('resi.print');
});

// common routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');    

    // route admin only
    Route::middleware('isAdmin')->group(function () {
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::get('/karyawan/edit/{karyawan}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    
        Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::patch('/karyawan/update/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/delete/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    
        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('/history/{resi}/print', [HistoryController::class, 'print'])->name('history.print');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
