<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanHamaController;

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

// Redirect root ke laporan
Route::get('/', function () {
    return redirect()->route('laporan.index');
});

// Resource routes untuk laporan hama
Route::resource('laporan', LaporanHamaController::class);

// Route khusus untuk statistik
Route::get('laporan-statistik', [LaporanHamaController::class, 'statistik'])->name('laporan.statistik');