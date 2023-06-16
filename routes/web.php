<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::any('/', 'App\Http\Controllers\HomeController@index')->name('index');
Route::any('/form', 'App\Http\Controllers\FormController@form');
Route::post('/getQuote', 'App\Http\Controllers\QuotationController@getQuote');
Route::get('/getQuote', 'App\Http\Controllers\QuotationController@getQuote');



