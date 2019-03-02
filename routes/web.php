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
*
/*
Route::get('/', function () {
    return view('welcome');
});
*/


Route::get('/', "User\UsersController@index");
Route::get('/sign-up.html', "Auth\RegisterController@signUp");
Route::post('/sign-up.html', "Auth\RegisterController@newUser");
Route::post('/sign-up.html/{id}', "Auth\RegisterController@newUser");
Route::get('/sign-in.html', 'User\UsersController@index');
Route::post('/sign-in.html', "Auth\LoginController@doLogin");
Route::post('api/sign-in', "Auth\LoginController@doLogin");
Route::get('logout', "Auth\LoginController@doLogout");
//Route::post('check/otp', "Customer\CustomersController@verifyOtp");
//Route::post('otp', function (){
//    dd(11);
//});


Route::get('/aa', function () {

})->middleware('authEntry');

//User related Routes
Route::group(['prefix' => 'secure'], function () {
    Route::group(['middleware' => ['checkEntry']], function () {
        //


        Route::get('/dashboard.html', 'Home\HomeController@index');

        Route::get('/items', 'Item\ItemsController@index');
        Route::get('/add-items', 'Item\ItemsController@addItem');
        Route::get('/add-items/{id}', 'Item\ItemsController@addItem');
        Route::post('/add-items/{id}', 'Item\ItemsController@saveItem');
        Route::post('/add-items', 'Item\ItemsController@saveItem');
        Route::post('/saveItem', 'Item\ItemsController@saveItem');

        Route::get('/view-item/{id}', 'Item\ItemsController@viewItem');

        Route::get('/categories', 'Category\CategoriesController@index');
        Route::get('/add-categories', 'Category\CategoriesController@addCategory');
        Route::get('/add-categories/{id}', 'Category\CategoriesController@addCategory');
        Route::post('/add-categories/{id}', 'Category\CategoriesController@saveCategory');
        Route::post('/add-categories', 'Category\CategoriesController@saveCategory');
//    Route::post('/saveCategory','Category\CategoriesController@saveCategory');

        Route::get('/add-users', 'Auth\RegisterController@addUser');


        Route::get('/customers', 'Customer\CustomersController@index');
        Route::get('/add-customers', 'Customer\CustomersController@addCustomer');
        Route::get('/add-customers/{id}', 'Customer\CustomersController@addCustomer');
        Route::post('/add-customers/{id}', 'Customer\CustomersController@saveCustomer');
        Route::post('/add-customers', 'Customer\CustomersController@saveCustomer');

        Route::get('/event', 'Event\EventController@index');
        Route::get('/add-event', 'Event\EventController@addEvent');
        Route::get('/add-event/{id}', 'Event\EventController@addEvent');
        Route::post('/add-event/{id}', 'Event\EventController@saveEvent');
        Route::post('/add-event', 'Event\EventController@saveEvent');

        Route::get('/userEvent', 'Event\EventController@userEventIndex');
        Route::get('/add-userEvent', 'Event\EventController@addUserEvent');
        Route::get('/add-userEvent/{id}', 'Event\EventController@addUserEvent');
        Route::post('/add-userEvent/{id}', 'Event\EventController@saveUserEvent');
        Route::post('/add-userEvent', 'Event\EventController@saveUserEvent');

        Route::get('/branch', 'Branch\BranchController@index');
        Route::get('/add-branch', 'Branch\BranchController@addBranch');
        Route::get('/add-branch/{id}', 'Branch\BranchController@addBranch');
        Route::post('/add-branch/{id}', 'Branch\BranchController@saveBranch');
        Route::post('/add-branch', 'Branch\BranchController@saveBranch');

        Route::get('/city', 'City\CityController@index');
        Route::get('/add-city', 'City\CityController@addCity');
        Route::get('/add-city/{id}', 'City\CityController@addCity');
        Route::post('/add-city/{id}', 'City\CityController@saveCity');
        Route::post('/add-city', 'City\CityController@saveCity');


        Route::get('/users', "User\UsersController@details");
        Route::get('/users/{id}', "User\UsersController@getupdateUser");
        Route::post('/users/{id}', "User\UsersController@saveUser");
        Route::get('/add-users', "User\UsersController@addUser");
        Route::post('/add-users', "User\UsersController@saveUser");
        Route::get('/CUser', "User\UsersController@getupdateUser");
        Route::post('/CUser', "User\UsersController@updateCurrentUser");

        Route::get('/attendance', "Attendance\AttendanceController@index");

//search
        Route::get('/sear-customers', "Sales\SalesController@searchSalesByCustomer");
        Route::get('/sear-userEvent', "Event\EventController@searchEventByName");
        Route::get('/sear-cux', "Customer\CustomersController@searchByCustomerName");
        Route::get('/sear-branch', "Branch\BranchController@searchByBranchName");
        Route::get('/sear-city', "City\CityController@searchByCityName");
        Route::get('/sear-attend', "Attendance\AttendanceController@searchByAttendance");
        Route::get('/qr-code', "QR\QRController@scanQRCode");


    });
});

Route::group(['prefix' => 'secureApi'], function () {
    //check nic and send otp
    Route::post('/check/nic', "Customer\CustomersController@getCustomer");

    //check otp and send 200 success
    Route::post('/check/otp', "Customer\CustomersController@verifyOtp");

});

Route::group(['prefix' => 'secured'], function () {
    //receive user_id and send all events the user is registered
    Route::post('/check/getUserEvents', "Event\EventController@getUserEvents");

    //
    Route::post('/check/qrCode', "Event\EventController@sendQR");


    Route::post('/check/attend', "Attendance\AttendanceController@attend");
});


//User related Routes
Route::group(['prefix' => 'user'], function () {
    Route::get('/add.html', 'User\UsersController@index');
    Route::get('/view.html/{id}', 'User\UsersController@view');
});

//Item related Routes
Route::group(['prefix' => 'item'], function () {
    Route::get('/add.html', 'Item\ItemsController@index');
    //Route::get('/view.html/{id}','Item\ItemsController@view');
});