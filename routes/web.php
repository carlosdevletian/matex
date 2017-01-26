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

Route::post('/contact', ['uses' => 'ContactController@store', 'as' => 'contacts.store']);

Route::post('/designs', ['uses' => 'DesignController@store', 'as' => 'designs.store']);

Route::get('/categories/{category}/designs/create', ['uses' => 'DesignController@create', 'as' => 'designs.create']);

Route::get('/categories', ['uses' => 'CategoryController@index', 'as' => 'categories.index']);

Route::get('/category/{category}/products', 'ProductController@index')->name('products.index');

Route::get('categories/{category}/designs/{design}/orders/create', ['uses' => 'OrderController@create', 'as' => 'order.create']);

Route::get('/orders/{order}', ['uses' => 'OrderController@show', 'as' => 'orders.show']);

Route::post('/orders', ['uses' => 'OrderController@store', 'as' => 'orders.store']);

Route::get('/dashboard', function () {return view('dashboard'); })->name('dashboard')->middleware('auth');

Auth::routes();

Route::get('images/{image}', function($image = null)
{
    $path = storage_path() . '/app/designs/' . $image;
    if(!File::exists($path)) abort(404);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('image_path');

Route::get('/cart', 'CartController@show')->name('carts.show');
Route::post('/addToCart', 'VueController@addToCart')->name('cart.add');
Route::post('/calculatePrice', 'VueController@calculatePrice')->name('calculate-price');

Route::get('/addresses', 'AddressController@index')->name('addresses.index');
Route::post('/addresses', 'AddressController@store')->name('addresses.store');
Route::put('/addresses/{id}', 'AddressController@update')->name('addresses.update');