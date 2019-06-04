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

Route::get('/', 'ProductsController@getIndex')->name('products.index');

Route::get('/terms', function(){
	return view('terms');
});

Route::get('/shop', 'ProductsController@getIndex')->name('products.index');

Route::get('/add-to-cart/{id}', 'ProductsController@getAddToCart')->name('products.addToCart');

Route::get('/shopping-cart', 'ProductsController@getCart')->name('products.shoppingCart');

Route::get('/add/{id}', 'ProductsController@getAddByOne')->name('products.addByOne');

Route::get('/reduce/{id}', 'ProductsController@getReduceByOne')->name('products.reduceByOne');

Route::get('/remove/{id}', 'ProductsController@getRemoveItem')->name('products.remove');

Route::get('/checkout', 'ProductsController@getCheckout')->name('checkout')->middleware('auth');

Route::post('/checkout', 'ProductsController@postCheckout')->name('checkout')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
