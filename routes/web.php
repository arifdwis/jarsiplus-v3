<?php

use Illuminate\Support\Facades\Route;

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
Route::get('home', 'App\Http\Controllers\HomeController@index')
    ->name('home')
    ->prefix(config('nue.route.prefix'));

Route::get('/home', 'App\Http\Controllers\HomeController@index');

Route::view('crud', 'crud')->middleware('nue.lock');

Route::any('/logout', 'Novay\SSO\Http\Controllers\OAuthController@logout')->name('logout');

// Global Route Aliases for Template Module
Route::get('/informasi', 'Modules\Template\Http\Controllers\TemplateController@informasi')->name('informasi');
Route::get('/faq', 'Modules\Template\Http\Controllers\FaqController@index')->name('faq');
Route::get('/statistik', 'Modules\Template\Http\Controllers\StatistikController@index')->name('statistik');


Route::get('/download/manual-pemohon', function () {
    return response()->download(storage_path('app/public/jarsiplus/informasi/Manual Pemohon.pdf'), 'Manual Pemohon JARSIPLUS.pdf', ['Content-Type' => 'application/pdf']);
})->name('download.manual-pemohon');

Route::get('/download/manual-verifikator', function () {
    return response()->download(storage_path('app/public/jarsiplus/informasi/Manual Verifikator.pdf'), 'Manual Verifikator JARSIPLUS.pdf', ['Content-Type' => 'application/pdf']);
})->name('download.manual-verifikator');


Route::get('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'store'])->middleware('throttle:5,10')->name('pengaduan.store');
Route::get('/jarsiplus/pengaduan', [\App\Http\Controllers\AdminPengaduanController::class, 'index'])->middleware('auth')->name('admin.pengaduan');
Route::get('/sikerja/pengaduan', [\App\Http\Controllers\AdminPengaduanController::class, 'index'])->middleware('auth')->name('admin.sikerja.pengaduan');

Route::get('/switch-role/{id}', function ($id) {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    $user = auth()->user();
    $role = $user->roles()->where('roles.id', (int) $id)->first();
    if ($role) {
        session(['active_role_id' => (int) $id]);
        $roleLabel = $role->name === 'Pembahas' ? 'Tim Verifikator' : ($role->name === 'Pemohon' ? 'Pemohon Inovasi' : $role->name);
        if (function_exists('notify')) {
            notify()->flash("Berhasil beralih ke peran: <b>{$roleLabel}</b>", 'success');
        }
    }
    return redirect()->back();
})->middleware('auth')->name('switch.role');
