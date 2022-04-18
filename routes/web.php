<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request; 
use App\Models\Mahasiswa_MataKuliah;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('mahasiswa', MahasiswaController::class);
Route::get('mahasiswa/nilai/{nim}', [MahasiswaController::class, 'khs']);
Route::get('/mahasiswa/cetak_pdf', [MahasiswaController::class, 'cetak_pdf'])->name('cetak_pdf');
