<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Controller;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\ProductsController@index');
Route::get('cart', 'App\Http\Controllers\ProductsController@cart');
Route::get('add-to-cart/{id}', 'App\Http\Controllers\ProductsController@addToCart');
Route::patch('update-cart', 'App\Http\Controllers\ProductsController@update');
Route::delete('remove-from-cart', 'App\Http\Controllers\ProductsController@remove');
route::get('add-product', 'App\Http\Controllers\ProductsController@add_product_page');
Route::post('add', 'App\Http\Controllers\ProductsController@addproduct');
