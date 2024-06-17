<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResiController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/resi', function() {
    return view('resi.index');
})->middleware(['auth', 'verified'])->name('resi');


Route::middleware('auth')->group(function () {
    Route::get('/resi', [ResiController::class, 'index'])->name('resi.index');
    Route::get('/resi/create', [ResiController::class, 'create'])->name('resi.create');
    Route::post('/resi', [ResiController::class, 'store'])->name('resi.store');
    Route::get('/resi/{resi}', [ResiController::class, 'details'])->name('resi.details');
    Route::get('/resi/{resi}/edit', [ResiController::class, 'edit'])->name('resi.edit');
    Route::put('/resi/{resi}', [ResiController::class, 'update'])->name('resi.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
