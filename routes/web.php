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

Route::get('/', 'RepositoryController@index')->name('get.index');
Route::get('/show', 'RepositoryController@show')->name('get.show');
Route::get('/clear', 'RepositoryController@clear')->name('get.clear');
Route::get('save/{id}', 'RepositoryController@save');
Route::get('delete/{id}', 'RepositoryController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
