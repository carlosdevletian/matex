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

Route::post('/designs', [
    'uses' => 'DesignController@store',
    'as' => 'designs.store'
]);

Route::get('/categories', [
    'uses' => 'CategoryController@index',
    'as' => 'categories.index'
]);

Route::get('/categories/{category}/designs/create', [
    'uses' => 'DesignController@create',
    'as' => 'designs.create'
]);

Route::get('categories/{category}/designs/{design}/orders/create', [
    'uses' => 'OrderController@create',
    'as' => 'order.create'
]);

Route::get('/category/{category}/products', 'ProductController@index');

// Route::get('/categories/{category}/designs/{design}/products/select', [
//     'uses' => 'ProductController@select',
//     'as' => 'products.select'
// ]);

Route::get('/orders/{order}', [
    'uses' => 'OrderController@show',
    'as' => 'orders.show'
]);

Route::post('/orders', [
    'uses' => 'OrderController@store',
    'as' => 'orders.store'
]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

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

Route::post('/calculatePrice', function() {
    switch (request()->product_id) {
        case 1:
            $price = request()->quantity * 10;
            return response()->json(['price' => $price], 200);
            break;

        case 2:
        $price = request()->quantity * 20;
        return response()->json(['price' => $price], 200);
        break;

        case 3:
            $price = request()->quantity * 30;
            return response()->json(['price' => $price], 200);
            break;

        case 4:
        $price = request()->quantity * 40;
        return response()->json(['price' => $price], 200);
        break;
        
        default:
            $price = request()->quantity * 50;
            return response()->json(['price' => $price], 200);
            break;
    }
});
