<?php

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

foreach (['sikerja', 'jarsiplus'] as $prefix) {
    Route::prefix($prefix)->as('epanel.')->middleware(['auth'])->group(function () {
       Route::get('bukti-dukung', 'BuktiDukungController@index')->name('bukti-dukung.index');
       Route::get('bukti-dukung/export', 'BuktiDukungController@export')->name('bukti-dukung.export');
       Route::post('permohonan/{id}/notifikasi-status', 'PermohonanController@notifyStatus')->name('permohonan.notify-status');
       Route::resources([
          'permohonan' => 'PermohonanController',
          'arsip' => 'ArsipController',
          'permohonan.penilaian' => 'PenilaianController',
          'penilaian.file' => 'FileController',
       ]);
       Route::get('arsip/{id}/penilaian', 'ArsipController@penilaian')->name('arsip.penilaian');
    });
}



Route::prefix('master')->as('epanel.')->middleware(['auth'])->group(function () {
   Route::resources([
      'kategori' => 'KategoriController',
      'kategori.urusan' => 'UrusanController',
      'indikator' => 'IndikatorController',
      'indikator.parameter' => 'ParameterController',
   ]);

});

Route::prefix('Beimbai')->as('epanel.')->middleware(['auth'])->group(function () {
   Route::resources([
      'beimbai-permohonan' => 'Beimbai\PermohonanController',
      'beimbai-indikator' => 'Beimbai\IndikatorController',
      // 'beimbai-permohonan.penilaian' => 'Beimbai\PenilaianController',
      'beimbai-indikator.parameter' => 'Beimbai\ParameterController',
   ]);

});
