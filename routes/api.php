<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SedekahController;
use App\Http\Controllers\JemputController;
use App\Http\Controllers\OutliteController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KategoriController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

Route::get('sedekahs', [SedekahController::class, 'index']);
Route::post('sedekahs', [SedekahController::class, 'store']);
Route::get('sedekahs/{id}', [SedekahController::class, 'show']);
Route::put('sedekahs/{id}', [SedekahController::class, 'update']);
Route::delete('sedekahs/{id}', [SedekahController::class, 'destroy']);

Route::get('jemputs', [JemputController::class, 'index']);
Route::post('jemputs', [JemputController::class, 'store']);
Route::get('jemputs/{id}', [JemputController::class, 'show']);
Route::put('jemputs/{id}', [JemputController::class, 'update']);
Route::delete('jemputs/{id}', [JemputController::class, 'destroy']);

Route::get('outlites', [OutliteController::class, 'index']);
Route::post('outlites', [OutliteController::class, 'store']);
Route::get('outlites/{id}', [OutliteController::class, 'show']);
Route::put('outlites/{id}', [OutliteController::class, 'update']);
Route::delete('outlites/{id}', [OutliteController::class, 'destroy']);

Route::get('kategoris', [KategoriController::class, 'index']);
Route::post('kategoris', [KategoriController::class, 'store']);
Route::get('kategoris/{id}', [KategoriController::class, 'show']);
Route::put('kategoris/{id}', [KategoriController::class, 'update']);
Route::delete('kategoris/{id}', [KategoriController::class, 'destroy']);

Route::get('riwayats', [RiwayatController::class, 'index']);
Route::post('riwayats', [RiwayatController::class, 'store']);
Route::get('riwayats/{id}', [RiwayatController::class, 'show']);
Route::put('riwayats/{id}', [RiwayatController::class, 'update']);
Route::delete('riwayats/{id}', [RiwayatController::class, 'destroy']);
//notifikasi
Route::get('sedekahs/valid/{id}', [SedekahController::class, 'valid_sedekah']);
Route::get('sedekahs/segera/{id}', [SedekahController::class, 'jemput_sedekah']);
Route::get('jemputs/valid/{id}', [JemputController::class, 'valid_jemput']);
Route::get('jemputs/segera/{id}', [JemputController::class, 'segera_jemput']);
//koin
Route::get('pencairan/{id}', [RiwayatController::class, 'request_pencairan']);
Route::get('pencairan/valid/{id}', [RiwayatController::class, 'validasi_pencairan']);

//lihat user super admin
Route::get('lihat/user/', [AuthController::class, 'lihat_user']);
//ganti user role
Route::get('ganti/user/role/{id}', [AuthController::class, 'ganti_userrole']);
//tampil daftar admin di super admin
Route::get('index/belum/valid/', [OutliteController::class, 'index_belum_valid']);
//validasi daftar outlite(super admin)
Route::get('index/sudah/valid/{id}', [OutliteController::class, 'user_valid']);

//perhitungan
Route::get('cari/outlite/{latitude}/{longitude}', [OutliteController::class, 'findNearestOutlite']);