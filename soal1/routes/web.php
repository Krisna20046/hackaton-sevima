<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KendaraanController;

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
Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');
Route::post('/upload', [KendaraanController::class, 'upload'])->name('kendaraan.upload');
Route::get('/upload', [KendaraanController::class, 'upload_index']);