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
    return view('home');
})->name('home');

Route::post('/contact', [
    'uses' => 'ContactController@store',
    'as' => 'contact'
]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');;

//Product Resource Route (REST) Si se quieren agregar mas rutas que las 7 de REST se deben agregar antes
Route::resource('products', 'ProductController');

Auth::routes();
