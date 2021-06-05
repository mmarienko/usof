<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::get('verify/{verification_code}', 'AuthController@verify');
    Route::post('password-reset/{recovery_code}', 'AuthController@recover');

    Route::middleware('jwt.auth')->post('logout', 'AuthController@logout');
    Route::middleware('jwt.auth')->post('me', 'AuthController@me');
    Route::middleware('jwt.auth')->post('password-reset', 'AuthController@reset');
    Route::middleware('jwt.auth')->post('refresh', 'AuthController@refresh');
});


Route::group([], function() {
    Route::get('posts', 'PostController@index');
    Route::get('posts/{post}', 'PostController@show');
    Route::middleware('jwt.auth')->post('posts', 'PostController@store');
    Route::middleware('jwt.auth')->patch('posts/{post}', 'PostController@update');
    Route::middleware('jwt.auth')->delete('posts/{post}', 'PostController@delete');
});