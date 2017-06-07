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


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Morilog\Jalali\Facades\jDate;

Route::get('/', function () {
    $user = Auth::user();
    return view('index',compact('user'));
});
//    ->middleware('checkUser');

// Static Routes

Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'flat') {
    return $captcha->src($config);
});

Route::get('/about', 'StaticsController@about');
Route::get('/terms', 'StaticsController@terms');
Route::get('/contact', 'StaticsController@contact');
Route::post('/contact', 'StaticsController@sendMail');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/home', 'HomeController@formController');

Route::get('/dotin', 'DotinController@dotinAuthorization');//maybe get,will implement according to the fake web service

Route::get('/profile', 'UserController@index');
Route::get('/beneficiaries', 'UserController@beneficiaries');
Route::get('/beneficiaries/add', 'UserController@addBeneficiary');
Route::get('/notifications', 'UserController@notifications');
Route::get('/settings', 'UserController@settings');
Route::get('/logout', 'Auth/LoginController@logout');
Route::get('/proforma', 'PaymentController@proforma');
Route::get('/invoice', 'PaymentController@invoice');

//Route::post('/pay', 'WalletController') ;
//
Route::post('/calculate', 'UptController@calculateRemittance')->name('calculate'); //maybe get, according to fake web service

//Route::get('/test', 'PaymentController@index');
Route::get('/test', 'PaymentController@test');
Route::get('/payment', 'PaymentController@pay');

Route::get('/callback/{callback}', 'CallbackController@callbackHandler');

Route::resource('/additional-info', 'UserInformationController');

Route::get('/ws', 'UptController@test');

Route::get('/{locale}', function ($locale) {
    App::setLocale($locale);
    return view('index');
});
