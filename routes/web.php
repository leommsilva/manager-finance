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
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@index')->name('categories');
        Route::post('/', 'CategoryController@store')->name('categories.store');
        Route::get('delete/{id}', 'CategoryController@delete')->name('categories.delete');
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', 'TransactionController@index')->name('transactions');
        Route::post('/', 'TransactionController@store')->name('transactions.store');
        Route::get('delete/{id}', 'TransactionController@delete')->name('transactions.delete');
        Route::get('verify/{id}', 'TransactionController@verify')->name('transactions.delete');

    });
});
