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

Route::resource('posts', 'PostController');
Route::resource('bounty-list', 'BountyListController');
Route::resource('twitter-account', 'TwitterAccountController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/twitter', 'TwitterAccountController@index')->name('twitter');
Route::get('/twitter1', 'BountyListController@index')->name('twitter1');
Route::get('/callback', 'TwitterAccountController@callback');
