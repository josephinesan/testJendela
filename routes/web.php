<?php

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
Route::get('/', function() {
    return redirect('/login');
});

Route::get('login', 'LoginController@view')->name('login');
Route::post('login', 'LoginController@login');

Route::group(
    ['middleware' => 'auth'], function () {
        Route::get('article/list', 'ArticleController@list');
        Route::get('article/detail', 'ArticleController@detail');
        Route::resource('article', 'ArticleController');
        Route::resource('comment', 'CommentController');
    }
);