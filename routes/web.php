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

Route::get('/home', 'TestProductsController@showIndexPage')->name('admin.index.show');
Route::post('/home', 'TestProductsController@showIndexPage');
Route::get('/', 'TestZZZController@showList');
Route::get('/logout', 'Auth\LoginController@loggedOut');

Route::get('/home/add_product', 'TestProductsController@showAddProductPage')->name('admin.add_product.show');
Route::post('/home/add_product', 'TestProductsController@addProduct')->name('admin.add_product.add');

Route::get('/home/detail/', 'TestProductsController@showDetailPage')->name('admin.detail.show');