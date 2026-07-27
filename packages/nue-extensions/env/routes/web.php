<?php

Route::group([
	'namespace' => 'Nue\Env\Http\Controllers', 
	'prefix' => 'nue', 
	'as' => 'nue.'
], function() {

	Route::resource('env', 'EnvController')->except(['show']);

});