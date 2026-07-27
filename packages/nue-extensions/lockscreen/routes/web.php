<?php

Route::group(['namespace' => 'Nue\Lock\Http\Controllers'], function() 
{
	Route::get('lock', 'LockController@lock')->name('nue-lock');
	Route::post('lock', 'LockController@unlock')->name('nue-unlock');
});