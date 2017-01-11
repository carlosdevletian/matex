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
    return view('home/home');
})->name('home');

Route::get('/about-us', function () {
    return view('about');
})->name('about');

Route::post('/contact', [
    'uses' => 'ContactController@store',
    'as' => 'contact'
]);

Route::get('/categories', [
    'uses' => 'CategoryController@index',
    'as' => 'categories.index'
]);

Route::get('/categories/{category}/designs/create', [
    'uses' => 'DesignController@create',
    'as' => 'designs.create'
]);

Route::get('/categories/{category}/designs/{design}/products/select', [
    'uses' => 'ProductController@select',
    'as' => 'products.select'
]);

Route::get('/orders/{order}', [
    'uses' => 'OrderController@show',
    'as' => 'orders.show'
]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Auth::routes();
