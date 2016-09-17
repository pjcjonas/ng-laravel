<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard',"DashboardController@index");
});


Route::get('/','Auth\AuthController@loginPage');
Route::get('/login','Auth\AuthController@loginPage');
Route::post('/postLogin','Auth\AuthController@postLogin');
