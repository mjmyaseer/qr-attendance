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


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');

//receive user_id and send all events the user is registered
    Route::post('/check/getUserEvents', "Event\EventController@getUserEvents");

    //
    Route::post('/check/qrCode', "Event\EventController@sendQR");


    Route::post('/check/attend', "Attendance\AttendanceController@attend");
});

