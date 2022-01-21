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

Route::get('/', function () {
    return view('welcome');
});

//routeの書き方
Route::group(['prefix' => 'XXX'],function() {
    Route::get('', 'AAAController@bbb');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');
    Route::get('news/edit', 'Admin\NewsController@edit');
    Route::get('profile/create', 'Admin\ProfileController@add')->middleware('auth');
    Route::get('profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
});


//13の追記部分

 Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
     Route::get('news/create', 'Admin\NewsController@add');
     Route::post('news/create', 'Admin\NewsController@create'); # 追記
     Route::get('news', 'Admin\NewsController@index')->middleware('auth'); #16で追記
     Route::get('news/edit', 'Admin\NewsController@edit')->middleware('auth'); #16で追記
     Route::post('news/edit', 'Admin\NewsController@update')->middleware('auth'); #16で追記
     Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth'); #16で追記
     
     Route::post('profile/create', 'Admin\ProfileController@create'); #13課題3で追記
     Route::post('profile/edit', 'Admin\ProfileController@update'); #13課題6で追記
     Route::get('profile/edit', 'Admin\ProfileController@edit'); #16課題1追記
 });     

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
