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

Route::get('/', function () { return view('home/home'); })->name('home');

Route::get('/about-us', function () { return view('about'); })->name('about');

Route::post('/contact','ContactController@store')->name('contacts.store');

Route::get('/dashboard', function () {return view('dashboard'); })->name('dashboard')->middleware('auth');

Route::post('/designs','DesignController@store')->name('designs.store');

Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/categories/{category}/designs/create', 'DesignController@create')->name('designs.create');
Route::get('/categories/{category}/products', 'ProductController@index')->name('products.index');
Route::get('categories/{category}/designs/{design}/orders/create', 'OrderController@create')->name('order.create');

Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
Route::post('/orders', 'OrderController@store')->name('orders.store');

Auth::routes();

Route::get('images/{image}/{forOrder?}', 'ImageController@show')->name('image_path');

Route::get('/cart', 'CartController@show')->name('carts.show');
Route::post('/addToCart', 'VueController@addToCart')->name('cart.add');
Route::post('/calculatePrice', 'VueController@calculatePrice')->name('calculate-price');
Route::post('/calculateShipping', 'VueController@calculateShipping')->name('calculate-shipping');
Route::post('/calculateTax', 'VueController@calculateTax')->name('calculate-tax');

Route::get('/addresses', 'AddressController@index')->name('addresses.index');
Route::post('/addresses', 'AddressController@store')->name('addresses.store');
Route::put('/addresses/{id}', 'AddressController@update')->name('addresses.update');