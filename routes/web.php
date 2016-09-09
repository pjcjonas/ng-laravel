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

Route::resource('/', 'welcome@index');
Route::resource('/register', 'register@index');
Route::resource('/login', 'login@index');
Route::resource('/products', 'products@index');
