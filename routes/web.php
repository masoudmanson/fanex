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

//Route::group([
//    'middleware' => 'auth:api',
//], function () {
//    // ...
//});
//
//// or ...
//
//Route::get('/users/{user}', 'UserController@show')->middleware('auth:api');





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/usertest', 'UserController@index')->middleware('auth:api');

Route::get('/sso', 'UserController@loginTest');
