<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
	'as' => 'index',
	'middleware' => ['guest'],
	'uses' => 'IndexController'
]);

Route::get('reset_pw', function () {
	return view('temp');
});

// related to login
Route::group(['as' => 'session.'], function () {
	Route::post('login', [
		'as' => 'store',
		'uses' => 'Auth\LoginController@login'
	]);
        Route::get('logout', [
		'as' => 'destroy',
		'uses' => 'Auth\LoginController@logout'
	]);
});

// related to register
Route::group(['as' => 'user.'], function () {
	Route::post('register', [
		'as' => 'store',
		'uses' => 'Auth\RegisterController@register'
	]);
	Route::post('reset_pw', [
		'as' => 'update',
		'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
	]);
});

// after login
Route::group(['middleware' => ['auth']], function () {
	Route::get('home', function() {
		$name = Auth::user()->name;
		return view('welcome', compact('name'));
	});
});
