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

// Route::resource('books','BooksController');

Route::get('books','BooksController@index')->name('books.index');
Route::post('books/{id?}','BooksController@store')->name('books.store');
Route::get('books/{id?}','BooksController@edit')->name('books.edit');
Route::delete('books/{id?}','BooksController@destroy')->name('books.delete');
