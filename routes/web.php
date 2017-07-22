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


Route::get('books/booksListPhpExcel', ['uses' => 'BooksController@booksListPhpExcel', 'as' => 'books.booksListPhpExcel']); //dinh nghia ham tao excel dung PHPExcel
Route::get('books/booksListLaravelExcel', ['uses' => 'BooksController@booksListLaravelExcel', 'as' => 'books.booksListLaravelExcel']); //dinh nghia ham tao excel dung Laravel Excel
Route::resource('books', 'BooksController'); //dinh nghia ham index, store, edit...
