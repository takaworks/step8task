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



Auth::routes();

Route::get('/home', 'TestProductsController@index')->name('home');
Route::post('/home', 'TestProductsController@index')->name('home');
Route::get('/', 'TestZZZController@showList')->name('zzz');
Route::get('/logout', 'Auth\LoginController@loggedOut');

Route::get('/home/add_product', 'TestProductsController@showAddProduct')->name('add_product');
Route::post('/home/add_product', 'TestValidateController@validateAddProduct')->name('add_product');