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

Route::get('/logout', 'Auth\LoginController@loggedOut');

Route::prefix('home')->group(function () {
    Route::get('', 'TestProductsController@showIndexPage')->name('admin.index.show');
    Route::post('', 'TestProductsController@showIndexPage');
    Route::post('ajaxsearch', 'TestProductsController@searchAjax')->name('admin.index.ajax');

    Route::get('add/', 'TestProductsController@showAddProductPage')->name('admin.addpage.show');
    Route::post('add/', 'TestProductsController@addProduct')->name('admin.add');

    Route::get('detail/{id}', 'TestProductsController@showDetailPage')->name('admin.detail');
    Route::get('edit/{id}', 'TestProductsController@showEditPage')->name('admin.editpage.show');
    Route::post('edit/{id}', 'TestProductsController@editProduct')->name('admin.edit');
    Route::delete('{id}', 'TestProductsController@deleteAjax')->name('admin.delete');
});