<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware('jwt.auth')->post('logout', 'AuthController@logout');
    Route::middleware('jwt.auth')->post('password-reset', 'AuthController@reset');
    Route::middleware('jwt.auth')->post('refresh', 'AuthController@refresh');

    Route::post('password-reset/{confirm_token}', 'AuthController@recover');
    Route::get('verify/{confirm_token}', 'AuthController@verify');
});

Route::group([], function() {
    Route::get('users', 'UserController@index');
    Route::get('users/{user_id}', 'UserController@show');
    Route::middleware('jwt.auth')->post('users', 'UserController@store');
    Route::middleware('jwt.auth')->post('users/avatar', 'UserController@avatar');
    Route::middleware('jwt.auth')->patch('users/{user_id}', 'UserController@update');
    Route::middleware('jwt.auth')->delete('users/{user_id}', 'UserController@delete');
});

Route::group([], function() {
    Route::get('posts', 'PostController@index');
    Route::get('posts/{post_id}', 'PostController@show');

    Route::middleware('jwt.auth')->post('posts', 'PostController@store');
    Route::middleware('jwt.auth')->patch('posts/{post}', 'PostController@update');
    Route::middleware('jwt.auth')->delete('posts/{post}', 'PostController@delete');
});

Route::group([], function() {
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category_id}', 'CategoryController@show');

    Route::middleware('jwt.auth')->post('categories', 'CategoryController@store');
    Route::middleware('jwt.auth')->patch('categories/{category_id}', 'CategoryController@update');
    Route::middleware('jwt.auth')->delete('categories/{category_id}', 'CategoryController@delete');
});

Route::group([], function() {
    Route::get('comments', 'CommentController@index');
    Route::get('comments/{comment_id}', 'CommentController@show');

    Route::middleware('jwt.auth')->post('comments', 'CommentController@store');
    Route::middleware('jwt.auth')->patch('comments/{comment_id}', 'CommentController@update');
    Route::middleware('jwt.auth')->delete('comments/{comment_id}', 'CommentController@delete');
});