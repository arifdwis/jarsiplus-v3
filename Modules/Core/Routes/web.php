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

// Route::prefix('core')->group(function() {
//     Route::get('/', 'CoreController@index');
// });

// Route::middleware('auth')->prefix('core')->name('core.')->group(function() {
//     Route::resource('kategori','KategoriController');
// });

Route::prefix('jarsiplus')->as('epanel.')->middleware(['auth'])->group(function() 
{
    Route::resources([
        'logpermohonan' => 'LogPermohonanController',
        'permohonan.file' => 'FileController',
        'permohonan.persetujuan' => 'PenjadwalanController',
        'file.pembahasan' => 'PembahasanController',
        'file.validasi' => 'ValidasiController',
        'laman' => 'LamanController',
    ]);

    Route::get('permohonan.penawaran', 'FileController@penawaran')->name('penawaran.index');
    Route::get('kesepakatan', 'FileController@kesepakatan')->name('kesepakatan.index');
    Route::get('perjanjian', 'FileController@perjanjian')->name('perjanjian.index');

});

Route::prefix('support')->as('epanel.')->middleware(['auth'])->group(function() 
{
    Route::resources([
        'slider' => 'SliderController',
    ]);

});