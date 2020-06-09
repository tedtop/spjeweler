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
    return redirect()->route('products');
});

Route::get('/products', 'ProductController@index')->name('products');
Route::get('/products/view/{id?}', 'ProductsController@view')->where('id', '[0-9]+');

Route::get('/tagger/{id?}', 'Tagger@index')->where('id', '[0-9]+');
Route::get('/tagger/autocomplete', 'Tagger@autocomplete');

Route::post('/tagger/addTag', 'Tagger@addTag');
Route::delete('tagger/deleteTag', 'Tagger@deleteTag');

Route::post('/tagger/next', 'Tagger@next');
