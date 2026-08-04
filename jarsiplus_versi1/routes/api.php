<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Template\Entities\MonoKecamatan;
use Modules\Template\Entities\MonoKelurahan;
use App\Http\Controllers\Api\PenjurianController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/kecamatan', function () {
    $data = apiSmr('v1/bank/monografi/kecamatan');
    foreach ($data as $key => $value) {
        $edit = MonoKecamatan::where('kecamatan_id',$value['kecamatan_id'])->first();
        $response[] = $edit->update($value);
    }
    return $response;
});

Route::get('/kelurahan', function () {
    $data = apiSmr('v1/bank/monografi/kelurahan');
    foreach ($data as $key => $value) {
        $edit = MonoKelurahan::where('kelurahan_id',$value['kelurahan_id'])->first();
        $response[] = $edit->update($value);
    }
    return $response;
});

// API untuk kebutuhan penjurian: permohonan + data dukung + indikator
Route::get('/permohonan', [PenjurianController::class, 'index']);

