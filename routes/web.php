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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/storagess', function () {
    Artisan::call('storage:link');
    return "yooo";
});

Route::get('/', function () {
    // return url('/login');
    return redirect()->route('login');
});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('dashboard','AdminController@index')->name('dashboard');
Route::post('/user-login','AdminController@login')->name('user-login');
Route::get('/app-users','AdminController@appUsers')->name('app-users');
#category
Route::get('/category','AdminController@getCategories')->name('category');
Route::get('/search-category','AdminController@getCategories')->name('search-category');
Route::post('/add-update-category','AdminController@addOrUpdate')->name('add-update-category');
Route::get('/delete-category','AjaxController@deleteCategory')->name('delete-category');
Route::get('update-view-category','AjaxController@RenderCategoryUpdateView');

#service feature
Route::get('/service-features','AdminController@getServiceFeature')->name('service-features');
Route::get('/search-service-feature','AdminController@getServiceFeature')->name('search-service-feature');
Route::post('/add-update-service-feature','AdminController@addOrUpdateServiceFeature')->name('add-update-service-feature');
Route::get('/delete-service-feature','AjaxController@deleteServiceFeature')->name('delete-service-feature');
Route::get('/update-view-service-feature','AjaxController@RenderServiceUpdateView');

#service feature Type
Route::get('/service-features-type','AdminController@getServiceFeatureType')->name('service-features-type');
Route::get('/search-service-type','AdminController@getServiceFeatureType')->name('search-service-type');
Route::post('/add-update-service-type','AdminController@addOrUpdateServiceType')->name('add-update-service-type');
Route::get('/delete-service-type','AjaxController@deleteServiceType')->name('delete-service-type');
Route::get('/update-view-service-type','AjaxController@RenderServiceTypeUpdateView');

#app users
Route::get('/app-users','AdminController@appUsers')->name('app-users');
Route::get('/search-app-users','AdminController@appUsers')->name('search-app-users');
Route::get('/delete-app-user','AjaxController@deleteAppUsers')->name('delete-app-user');

#transactions
Route::get('/users-transactions','AdminController@UsersAllTransactions')->name('users-transactions');
Route::get('/service-deliveries','AdminController@getDeliveries')->name('service-deliveries');
Route::get('/search-transactions','AdminController@UsersAllTransactions')->name('search-transactions');

#Service deliveries
Route::get('/service-deliveries','AdminController@getDeliveries')->name('service-deliveries');
Route::get('/search-service-deliveries','AdminController@getDeliveries')->name('search-service-deliveries');
Route::get('/view-assigned-service-provider','AjaxController@getAssignedServiceProviders')->name('view-assigned-service-provider');
Route::get('/view-assigned-user','AjaxController@getAssignedUser')->name('view-assigned-user');
Route::post('/select-majdoors','AjaxController@selectMajdoors')->name('select-majdoors');
Route::get('/view-feedback','AjaxController@viewFeedback')->name('view-feedback');

#service providers
Route::get('/service-providers','AdminController@getAllMajdoors')->name('service-providers');
Route::get('/search-service-providers','AdminController@getAllServiceProviders')->name('search-service-providers');
Route::post('/import-file',['as'=>'import-file', 'uses'=>'AdminController@import']);
Route::get('/delete-service-provider','AjaxController@deleteServiceProvider');
Route::get('/update-view-service-provider','AjaxController@RenderServiceProviderUpdateView');
Route::post('/add-update-service-provider','AdminController@addUpdateMajdoor')->name('add-update-service-provider');
Route::get('/change-status/{id}','AdminController@changeStatus')->name('change-status');

#State
Route::get('/state','AdminController@getStates')->name('state');
Route::post('/add-update-state','AdminController@addUpdateState')->name('add-update-state');
Route::get('/update-view-state','AjaxController@RenderStateUpdateView');
Route::get('/delete-state','AjaxController@deleteState');
Route::get('/search-state','AdminController@getStates')->name('search-state');

#city
Route::get('/city','AdminController@getCities')->name('city');
Route::post('/add-update-city','AdminController@addUpdateCity')->name('add-update-city');
Route::get('/update-view-city','AjaxController@RenderCityUpdateView');
Route::get('/delete-city','AjaxController@deleteCity');
Route::get('/search-city','AdminController@getCities')->name('search-city');







 