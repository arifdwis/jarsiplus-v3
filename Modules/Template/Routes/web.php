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

// Route::prefix('template')->group(function() {
//     Route::get('/', 'TemplateController@index');
// });

Route::get('/maintenance','TemplateController@maintenance')->name('maintenance');
Route::get('/','TemplateController@index')->name('welcome');
Route::get('/informasi','TemplateController@informasi')->name('informasi.index');
Route::get('/statistik','StatistikController@index')->name('statistik.index');
Route::get('/web','TemplateController@maintenance')->name('maintenance');
Route::get('/faq',function(){
	return view("template::faq.index");
})->name('faq.index');


Route::middleware('auth')->group(function() {
	Route::resource('permohonan','PermohonanController');
	Route::get('permohonan/{uuid}/persetujuan','PermohonanController@persetujuan')->name('permohonan.persetujuan');
	Route::match(['put', 'post'], 'permohonan/{uuid}/kirim', 'PermohonanController@kirim')->name('permohonan.kirim');
	Route::prefix('permohonan')->name('permohonan.')->group(function() {
		Route::get('/{uuid}/detail','PermohonanController@detail')->name('detail');
		Route::get('/{uuid}/pembahasan','PembahasanController@index')->name('pembahasan.index');

		// Route::get('/{uuid}/persetujuan','PermohonanController@persetujuan')->name('persetujuan');
		// Route::post('/{uuid}/persetujuan/store','PermohonanController@persetujuanstore')->name('persetujuanstore');

		Route::get('/{uuid}/riwayat','PermohonanController@riwayat')->name('riwayat');
		Route::get('/{uuid}/finish','PermohonanController@finish')->name('finish');
	});
	
	Route::resource('permohonan.berkas','BerkasController')->only('index','create','edit','update','store');

	Route::resource('permohonan.indikator','IndikatorController')->only('index','edit','update');
	Route::resource('indikator.data','DataController')->only('index','create','edit','update','store');
	Route::resource('indikator.data.pembahasan','PembahasanController')->only('index','store');
	Route::put('indikator/{parent}/data/{uuid}/validate','DataController@validate')->name('indikator.data.validate');

	Route::get('/settings',function(){
		return view("template::settings.index");
	})->name('settings');

	Route::namespace('Settings')->prefix('settings')->name('settings.')->group(function() {
		Route::resource('account','AccountController')->only('index','update');
		Route::resource('profile','ProfileController')->only('index','update');
		Route::resource('corporate','CorporateController')->only('index','update');
	});

	Route::resource('beimbai','Beimbai\PermohonanController');
	Route::get('beimbai/{uuid}/detail','Beimbai\PermohonanController@detail')->name('beimbai.permohonan.detail');
	Route::get('/{uuid}/riwayat','Beimbai\PermohonanController@riwayat')->name('beimbai.riwayat');
	Route::get('/{uuid}/finish','Beimbai\PermohonanController@finish')->name('beimbai.finish');
	
});
