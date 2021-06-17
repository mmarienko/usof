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
    Route::post('password-reset/{confirm_token}', 'AuthController@recover');
    Route::get('verify/{confirm_token}', 'AuthController@verify');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('password-reset', 'AuthController@reset');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['prefix' => 'users'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');

        Route::get('{user_id}', 'UserController@show');
        Route::patch('{user_id}', 'UserController@update');
        Route::delete('{user_id}', 'UserController@delete');

        Route::post('avatar', 'UserController@avatar');
    });
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', 'PostController@index');
    Route::get('{post_id}', 'PostController@show');
    Route::get('{post_id}/comments', 'PostController@comments');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/', 'PostController@store');

        Route::patch('{post_id}', 'PostController@update');
        Route::delete('{post_id}', 'PostController@delete');

        Route::post('{post_id}/comments', 'PostController@comment');
        Route::get('{post_id}/categories', 'PostController@categories');
        Route::get('{post_id}/like', 'PostController@likes');
        Route::post('{post_id}/like', 'PostController@like');
        Route::delete('{post_id}/like', 'PostController@deleteLike');
    });
});

Route::group(['prefix' => 'categories'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/', 'CategoryController@index');
        Route::post('/', 'CategoryController@store');

        Route::get('{category_id}', 'CategoryController@show');
        Route::patch('{category_id}', 'CategoryController@update');
        Route::delete('{category_id}', 'CategoryController@delete');

        Route::get('{category_id}/posts', 'CategoryController@posts');
    });
});

Route::group(['prefix' => 'comments'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('{comment_id}', 'CommentController@show');
        Route::patch('{comment_id}', 'CommentController@update');
        Route::delete('{comment_id}', 'CommentController@delete');

        Route::get('{comment_id}/like', 'CommentController@likes');
        Route::post('{comment_id}/like', 'CommentController@like');
        Route::delete('{comment_id}/like', 'CommentController@deleteLike');
    });
});
