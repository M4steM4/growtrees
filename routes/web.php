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

Route::get('/', function () {
    return view('index');
});

Route::group(['as' => 'session.'], function () {
	Route::post('login', [
		'as' => 'store',
		'uses' => 'Auth\LoginController@postLogin'
	]);
        Route::get('logout', [
		'as' => 'destroy',
		'uses' => 'Auth\LoginController@getLogout'
	]);
});

Route::group(['middleware' => ['auth']], function () {

});
