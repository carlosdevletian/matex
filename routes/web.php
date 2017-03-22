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

Route::get('/dashboard','DashboardController@show')->name('dashboard')->middleware('auth');
Route::post('/searchClient','DashboardController@searchClient')->name('search.client')->middleware('admin');
Route::post('/searchOrder','DashboardController@searchOrder')->name('search.order')->middleware('admin');

Route::get('/profile','UserController@edit')->name('users.edit')->middleware('auth');
Route::put('/profile','UserController@update')->name('users.update')->middleware('auth');
Route::get('/users','UserController@index')->name('users.index')->middleware('auth');
Route::get('/users/{user}','UserController@show')->name('users.show')->middleware('admin');

Route::get('/designs','DesignController@index')->name('designs.index')->middleware('auth');
Route::post('/designs','DesignController@store')->name('designs.store');
Route::get('/design/{category}/{design?}', 'DesignController@create')->name('designs.create');

Route::get('/items', 'ItemController@index')->name('items.index');
Route::put('/items/{item}', 'ItemController@update')->name('items.update');
Route::delete('/items/{item}', 'ItemController@destroy')->name('items.destroy');

Route::get('/categories/create', 'CategoryController@create')->name('categories.create')->middleware('admin');
Route::post('/categories', 'CategoryController@store')->name('categories.store')->middleware('admin');
Route::put('/categories/{category}', 'CategoryController@update')->name('categories.update')->middleware('admin');
Route::get('/categories/{design?}', 'CategoryController@index')->name('categories.index');
Route::get('/categories/edit/{category}', 'CategoryController@edit')->name('categories.edit')->middleware('admin');
Route::get('/categories/{category}/products', 'ProductController@index')->name('products.index');

Route::get('/orders', 'OrderController@index')->name('orders.index')->middleware('auth');
Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
Route::post('/orders', 'OrderController@store')->name('orders.store');
Route::get('/order/{category}/{design?}', 'OrderController@create')->name('orders.create');

Auth::routes();

Route::get('images/{image}/{forOrder?}', 'ImageController@show')->name('image_path');

Route::get('/cart', 'CartController@show')->name('carts.show')->middleware('auth');
Route::post('/addToCart', 'VueController@addToCart')->name('carts.add')->middleware('auth');
Route::post('/calculatePrice', 'VueController@calculatePrice')->name('calculate-price');
Route::post('/calculateShipping', 'VueController@calculateShipping')->name('calculate-shipping');
Route::post('/calculateTax', 'VueController@calculateTax')->name('calculate-tax');
Route::post('/prepareOrder', 'VueController@prepareOrder')->name('prepare-order');

Route::post('/pay', 'VueController@pay')->name('pay');

Route::get('/addresses', 'AddressController@index')->name('addresses.index')->middleware('auth');
Route::get('/addresses/{address}', 'AddressController@edit')->name('addresses.edit')->middleware('auth');
Route::post('/addresses', 'AddressController@store')->name('addresses.store');
Route::put('/addresses/{address}', 'AddressController@update')->name('addresses.update')->middleware('auth');
Route::delete('/addresses/{address}', 'AddressController@destroy')->name('addresses.destroy')->middleware('auth');
