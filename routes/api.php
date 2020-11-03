<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ======================= Provider App =======================
Route::get('provider/getServiceCategory', 'API\APIProviderController@getServiceCategory');
Route::post('provider/register', 'API\APIProviderController@register');
Route::post('provider/login', 'API\APIProviderController@login');
Route::post('provider/requests', 'API\APIProviderController@requests');
Route::post('provider/requestdetail', 'API\APIProviderController@requestdetail');
Route::post('provider/accept', 'API\APIProviderController@accept');
Route::post('provider/reject', 'API\APIProviderController@reject');
Route::post('provider/updateStatus', 'API\APIProviderController@updateStatus');
Route::post('provider/declienAndRateRequest', 'API\APIProviderController@declienAndRateRequest');
Route::post('provider/declien', 'API\APIProviderController@declien');
Route::post('provider/delete', 'API\APIProviderController@delete');
Route::post('provider/editProfile', 'API\APIProviderController@editProfile');
Route::post('provider/getWorkSchedule', 'API\APIProviderController@getWorkSchedule');
Route::post('provider/updateWorkSchedule', 'API\APIProviderController@updateWorkSchedule');

// ======================= Customer App =======================
Route::post('customer/register', 'API\APICustomerController@register');
Route::post('customer/login', 'API\APICustomerController@login');
Route::get('customer/getDataforHome', 'API\APICustomerController@getDataforHome');
Route::post('customer/getWorkSchedule', 'API\APICustomerController@getWorkSchedule');
Route::post('customer/sendRequest', 'API\APICustomerController@sendRequest');
Route::post('customer/getNewRequests', 'API\APICustomerController@getNewRequests');
Route::post('customer/getNewRequest', 'API\APICustomerController@getNewRequest');
Route::post('customer/closeRequest', 'API\APICustomerController@closeRequest');
Route::post('customer/getActiveRequests', 'API\APICustomerController@getActiveRequests');
Route::post('customer/getActiveRequest', 'API\APICustomerController@getActiveRequest');
Route::post('customer/completeAndRateRequest', 'API\APICustomerController@completeAndRateRequest');
Route::post('customer/declienAndRateRequest', 'API\APICustomerController@declienAndRateRequest');
Route::post('customer/completeRequest', 'API\APICustomerController@completeRequest');
Route::post('customer/declienRequest', 'API\APICustomerController@declienRequest');
Route::post('customer/getHistoryRequests', 'API\APICustomerController@getHistoryRequests');
Route::post('customer/getHistoryRequest', 'API\APICustomerController@getHistoryRequest');
Route::post('customer/deleteRequest', 'API\APICustomerController@deleteRequest');
Route::post('customer/editProfile', 'API\APICustomerController@editProfile');