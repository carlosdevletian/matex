<?php

Route::get('/', function () { return view('home/home'); })->name('home');
Route::get('/about-us', function () { return view('about'); })->name('about');
Route::get('/faq', function () { return view('faq'); })->name('faq');
Route::post('/contact','ContactController@store')->name('contacts.store');
Route::post('/designs','DesignController@store')->name('designs.store');
Route::get('/design/{category}/{design?}', 'DesignController@create')->name('designs.create');
Route::get('/categories', 'CategoryController@index')->name('categories.index');
// Route::get('/categories/{category}/products', 'ProductController@index')->name('products.index');
Route::get('/orders/{order}/{token?}', 'OrderController@show')->name('orders.show');
// Route::post('/orders', 'OrderController@store')->name('orders.store');
Route::get('/order/{category}/{design?}', 'OrderController@create')->name('orders.create');
Route::get('/shop', 'ShopController@index')->name('shop.index');
Route::get('/shop/{category}', 'ShopCategoryController@index')->name('shop-category.index');
Route::post('/items/create','ItemController@create')->name('items.create');
Route::put('/items/{item?}', 'ItemController@update')->name('items.update');
Auth::routes();
Route::get('/register/token/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register.client');
Route::post('/register/guest', 'Auth\RegisterController@storeClient')->name('store.client');
Route::get('images/{image}/{forOrder?}', 'ImageController@show')->name('image_path');
Route::post('/validateEmailAddress', 'VueController@validateEmail')->name('validate-email');
Route::post('/calculatePrice', 'VueController@calculatePrice')->name('calculate-price');
Route::post('/calculateTax', 'VueController@calculateTax')->name('calculate-tax');
Route::post('/pay', 'VueController@pay')->name('pay');
Route::post('/retryPayment', 'VueController@retryPayment')->name('retryPayment');
Route::post('/addresses', 'AddressController@store')->name('addresses.store');
Route::get('/accessories/category/{category}', 'VueController@getAccessories')->name('category-accessories.index');

 /* AUTH ROUTES */
Route::group(['middleware' => 'auth'], function () {
    // Dashboard
    Route::get('/dashboard','DashboardController@show')->name('dashboard');
    // Users
    Route::get('/profile','UserController@edit')->name('users.edit');
    Route::put('/profile','UserController@update')->name('users.update');
    // Designs
    Route::get('/designs/{user?}','DesignController@index')->name('designs.index');
    // Orders
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    // Carts
    Route::get('/cart', 'CartController@show')->name('carts.show');
    Route::get('/cartPreview', 'VueController@cartPreview')->name('carts.preview');
    Route::post('/addToCart', 'VueController@addToCart')->name('carts.add');
    // Addresses
    Route::get('/addresses', 'AddressController@index')->name('addresses.index');
    Route::delete('/addresses/{address}', 'AddressController@destroy')->name('addresses.destroy');
    // Items
    Route::delete('/items/{item}', 'ItemController@destroy')->name('items.destroy');
});

 /* OWNER ROUTES */
Route::group(['middleware' => 'owner'], function () {
    Route::get('/users/create','UserController@create')->name('users.create');
    Route::get('/admins', 'AdminController@index')->name('admins.index');
    Route::delete('/admins/{user}', 'AdminController@destroy')->name('admins.delete');

    Route::put('/currency-rates/{rate}', 'CurrencyRateController@update')->name('currency-rate.update');
});

 /* ADMIN ROUTES */
Route::group(['middleware' => 'admin'], function () {
    // Contact
    Route::post('/contact-user','ContactController@contactUser')->name('contact.user');
    // Dashboard
    Route::post('/searchClient','DashboardController@searchClient')->name('search.client');
    Route::post('/searchOrder','DashboardController@searchOrder')->name('search.order');
    // Users
    Route::get('/users','UserController@index')->name('users.index');
    Route::post('/users','UserController@store')->name('users.store');
    Route::get('/users/{user}','UserController@show')->name('users.show');
    Route::post('user/{user}/adminComment','UserController@adminComment')->name('users.admin-comment');
    // Categories
    Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
    Route::post('/categories', 'CategoryController@store')->name('categories.store');
    Route::put('/categories/{category}', 'CategoryController@update')->name('categories.update');
    Route::get('/categories/edit/{category}', 'CategoryController@edit')->name('categories.edit');
    Route::get('/categories/designs/{category}', 'CategoryController@designsIndex')->name('categories.designs');
    Route::get('/categories/designs/add/{category}', 'CategoryController@addDesign')->name('categories.add-design');
    Route::post('/categories/designs/{category}', 'CategoryController@storeDesign')->name('categories.store-design');
    Route::put('/categories/{category}/products', 'CategoryController@updateProducts')->name('categories.update-products');
    Route::get('/categories/edit/{category}/products', 'CategoryController@editProducts')->name('categories.edit-products');
    Route::get('/category/disable/{category}', 'CategoryController@disable')->name('categories.disable');
    Route::get('/category/enable/{category}', 'CategoryController@enable')->name('categories.enable');
    // Pricings
    Route::get('/pricings/{category}', 'CategoryPricingController@index')->name('pricings.index');
    Route::post('/pricings/{category}', 'CategoryPricingController@store')->name('pricings.store');
    Route::put('/pricings', 'CategoryPricingController@update')->name('pricings.update');
    Route::delete('/pricings/{pricing}', 'CategoryPricingController@destroy')->name('pricings.delete');
    // Orders
    Route::put('/orders/{order}', 'OrderController@update')->name('orders.update');
    // Items
    Route::get('/items', 'ItemController@index')->name('items.index');
    // Designs
    Route::delete('/designs/{design}', 'DesignController@destroy')->name('designs.delete');
    // Addresses
    Route::get('/addresses/{address}', 'AddressController@edit')->name('addresses.edit');
    Route::put('/addresses/{address}', 'AddressController@update')->name('addresses.update');
    // Accessories
    Route::get('/categories/accessories/{category}', 'AccessoryController@index')->name('accessories.index');
    Route::get('/categories/accessories/add/{category}', 'AccessoryController@create')->name('accessories.create');
    Route::post('/categories/accessories/{category}', 'AccessoryController@store')->name('accessories.store');
    Route::get('/accessories/{accessory}', 'AccessoryController@edit')->name('accessories.edit');
    Route::put('/accessories/{accessory}', 'AccessoryController@update')->name('accessories.update');
    Route::get('/accessory/enable/{accessory}', 'AccessoryController@enable')->name('accessories.enable');
    Route::get('/accessory/disable/{accessory}', 'AccessoryController@disable')->name('accessories.disable');
});