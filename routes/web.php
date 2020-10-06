<?php
////////////////////////////////////  Authentication Urls   //////////////////////////////////////
// Route::get('/', 'Client\ClientController@ballot')->name('client.ballot');
Route::get('/', function() {
    return redirect('admin/');
});

Route::prefix('/onlineforum')->group(function() {
    Route::get('/', 'ForumClient\HomeController@index')->name('onlineforum');
});

// ================ Admin Panel URLS =====================

Route::get('admin/', 'AuthController@login')->name('request');

Route::get('/forgotPassword', 'AuthController@forgotPassword')->name('request');
Route::get('/logout', 'AuthController@logout')->name('request');
Route::post('/login', 'AuthController@loginApi')->name('request');

////////////////////////////////////  Sidebar Urls   //////////////////////////////////////
Route::get('/dashboard', 'Home\HomeController@index')->name('request');
Route::get('/performance', 'PerformenceController@index')->name('request');
Route::get('/setting', 'SettingController@index')->name('request');

////////////////////////////////////  User management Urls   //////////////////////////////////////
Route::get('/userManagement', 'UserController@index')->name('request');
Route::get('/editCustomerView/{id}', 'UserController@editCustomerView')->name('request');
Route::get('/editProviderView/{id}', 'UserController@editProviderView')->name('request');
Route::get('/customerPreView/{id}', 'UserController@customerPreView')->name('request');
Route::get('/providerPreView/{id}', 'UserController@providerPreView')->name('request');
Route::post('/editCustomer', 'UserController@editCustomer')->name('request');
Route::post('/editProvider', 'UserController@editProvider')->name('request');
Route::post('/deleteCustomer', 'UserController@deleteCustomer')->name('request');
Route::post('/deleteProvider', 'UserController@deleteProvider')->name('request');

////////////////////////////////////  Service Category management Urls   //////////////////////////////////////
Route::get('/serviceCategory', 'ServiceCategoryController@index')->name('request');
Route::post('/addServiceCategory', 'ServiceCategoryController@addServiceCategory')->name('request');
Route::post('/editServiceCategory', 'ServiceCategoryController@editServiceCategory')->name('request');
Route::post('/deleteServiceCategory', 'ServiceCategoryController@deleteServiceCategory')->name('request');

////////////////////////////////////  Service Request management Urls   //////////////////////////////////////
Route::get('/requests', 'RequestsController@index')->name('request');
Route::post('/deleteRequest', 'RequestsController@deleteRequest')->name('request');

////////////////////////////////////  Service management Urls   //////////////////////////////////////
Route::get('/services', 'ServicesController@index')->name('request');
Route::post('/deleteService', 'ServicesController@deleteService')->name('request');

////////////////////////////////////  Service History management Urls   //////////////////////////////////////
Route::get('/history', 'HistoryController@index')->name('request');
Route::post('/deleteHistory', 'HistoryController@deleteHistory')->name('request');

////////////////////////////////////  Online Forum Urls   /////////////////////////////////////////
Route::prefix('/forum')->group(function() {

    // ------------------- Category Urls --------------------------
    Route::get('/category', 'OnlineForum\CategoryController@index')->name('request');
    Route::post('/createCategory', 'OnlineForum\CategoryController@createCategory')->name('request');
    Route::post('/createSubcategory', 'OnlineForum\CategoryController@createSubcategory')->name('request');
    Route::post('/updateCategory', 'OnlineForum\CategoryController@updateCategory')->name('request');
    Route::post('/deleteCategory', 'OnlineForum\CategoryController@deleteCategory')->name('request');
    Route::post('/multiDeleteCategory', 'OnlineForum\CategoryController@multiDeleteCategory')->name('request');
});

