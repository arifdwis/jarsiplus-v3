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
