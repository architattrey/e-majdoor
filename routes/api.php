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
Route::post('/login','UserApiController@login');
Route::post('/update-user-profile','UserApiController@appUserProfileUpdate');
Route::post('/upload-image','UserApiController@imageUpload');
Route::post('/update-firebase-token','UserApiController@updateFireBaseToken');
Route::post('/get-all-categories','UserApiController@getAllCategories');
Route::post('/get-all-sub-categories','UserApiController@getAllSubCategories');
Route::post('/get-all-banners','UserApiController@getAllBanners');
Route::post('/get-all-service-features','UserApiController@getAllServiceFeatures');
Route::post('/get-all-service-features-type','UserApiController@getAllServiceFeaturesTypes');

Route::post('/add-to-cart','UserApiController@addToCart');
Route::post('/view-cart','UserApiController@viewCartOfUser');
Route::post('/delete-cart-service','UserApiController@deleteserviceFromCart');
Route::post('/add-delivery-address','UserApiController@AddUsersDeliveryAddress');
Route::post('/get-delivery-address','UserApiController@getDeliveryAddress');
Route::post('/delete-delivery-address','UserApiController@deleteDeliveryAddress');
Route::post('/submit-transaction','UserApiController@submitTransaction');
// Route::post('/send-sms-to-service-provider','UserApiController@sendSmsForServiceProvider');

Route::post('/update-transaction-status','UserApiController@updateTransaction');
Route::post('/old-transactions','UserApiController@oldTransactions');
Route::post('/add-user-referal-code','UserApiController@addReferalCode');
Route::post('/add-redemeed-data','UserApiController@addRedemeedData');
Route::post('/get-wallet-data','UserApiController@getAllWalletAmount');
Route::post('/get-search-data','UserApiController@searchBySubCategory');
Route::post('/price-addition','UserApiController@additionOfAmount');
Route::post('/get-all-states','UserApiController@getAllStates');
Route::post('/get-all-cities','UserApiController@getAllCities');
Route::post('/add-feedback','UserApiController@addFeedbacks');
Route::get('/get-users-feedbacks','UserApiController@getUsersFeedback');
Route::post('/give-user-raiting','UserApiController@userUpdateRaiting');

#majdoor api
Route::post('/majdoor-login','MajdoorApiController@majdoorLogin');
Route::post('/majdoor-update-user-profile','MajdoorApiController@majdoorProfileUpdate');
Route::post('/majdoor-upload-image','MajdoorApiController@imageUpload');
Route::post('/change-status','MajdoorApiController@changeStatus');
Route::post('/majdoor-update-firebase-token','MajdoorApiController@updateFireBaseToken');
Route::post('/orders-details','MajdoorApiController@getOrderDetails');
Route::post('/give-manager-raiting','MajdoorApiController@majdurUpdateRaiting');