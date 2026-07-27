<?php 

use Novay\Nue\Features;

Route::group([
	'namespace' => 'App\Http\Controllers', 
	'middleware' => config('nue.route.middleware', ['web', 'nue']), 
	'prefix' => config('nue.route.prefix', '')
], function () {

	// Auth Namespace...
	Route::group(['namespace' => 'Auth'], function () 
	{

		// Login & Logout...
		Route::get('login', 'LoginController@showLoginForm')->name('login');
		Route::post('login', 'LoginController@login');
		Route::post('logout', 'LoginController@logout')->name('logout');

		// Registration...
		if (Features::enabled(Features::registration())) {
			Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
			Route::post('register', 'RegisterController@register');
		}

		// Password Reset...
		if (Features::enabled(Features::resetPasswords())) {
			Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
			Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
			Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
			Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

			Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
			Route::post('password/confirm', 'ConfirmPasswordController@confirm');
		}

		// Email Verification...
		if (Features::enabled(Features::emailVerification())) {
			Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
			Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
			Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
		}
	});
	
	// Nue Namespace...
	Route::group(['namespace' => 'Nue', 'middleware' => 'auth'], function () 
	{
		// Update Profile Informations...
		if (Features::enabled(Features::updateProfile())) {
			Route::group(['prefix' => 'profile'], function () 
			{
				// User & Profile...
				Route::get('/', 'ProfileController@show')->name('profile.show');

				// Profile Information, Update Password & Change Photo...
				Route::put('/', 'ProfileController@update')->name('profile.update');

				// Terminate Account...
				if (Features::enabled(Features::terminateAccount())) {
					Route::delete('/', 'ProfileController@destroy')->name('profile.destroy');
				}
			});
		}

		// Nue Initialize...
		Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () 
		{
			Route::resource('users', 'UserController');
			Route::resource('roles', 'RoleController');
			Route::resource('permission', 'PermissionController');
			Route::resource('menu', 'MenuController')->except(['create']);
			Route::resource('log-activity', 'LogActivityController')->only(['index', 'destroy']);
		});
	});
});