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

//    ->middleware('checkUser');

// Static Routes


//Route::get('/{lang}', function($lang){
////    dd($lang);
////    App::setLocale($lang);
//    return redirect()->back();
//});//->where('lang', '/^[A-Za-z]{2}$/');


//Route::group(
//    [
//        'prefix' => LaravelLocalization::setLocale(),
//        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
//    ],
//    function () {


Route::get('/', 'HomeController@index')->name('index');

Route::get('/about', 'StaticsController@about');
Route::get('/terms', 'StaticsController@terms');
Route::get('/contact', 'StaticsController@contact');
Route::post('/contact', 'StaticsController@sendMail');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/home', 'HomeController@formController');

Route::get('/dotin', 'DotinController@dotinAuthorization');//maybe get,will implement according to the fake web service

Route::get('/profile', 'UserController@index');
Route::resource('/beneficiaries', 'BeneficiaryController');

Route::get('/notifications', 'UserController@notifications');
Route::get('/settings', 'UserController@settings');
Route::get('/logout', 'Auth\LoginController@logout');
//        Route::get('/proforma', 'PaymentController@proforma');
Route::get('/invoice', 'PaymentController@issueInvoice');
Route::get('/invoice/show', 'PaymentController@showInvoice');

//Route::post('/pay', 'WalletController') ;

Route::get('/test', 'PaymentController@test');
Route::get('/payment', 'PaymentController@pay'); //todo: load beneficiary page, go to beneficiary controller?

Route::get('/callback/{callback}', 'CallbackController@callbackHandler');

Route::get('/emad', 'PaymentController@test');
Route::get('/ws', 'UptController@test');
Route::get('/cookie', 'PaymentController@test');

Route::resource('/additional-info', 'UserInformationController');
Route::post('/proforma', 'PaymentController@proforma_with_new_bnf');
Route::post('/proforma/selected', 'PaymentController@proforma_with_selected_bnf');

//    });

Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'flat') {
    return $captcha->src($config);
});

Route::post('/calculate', 'UptController@calculateRemittance')->name('calculate'); //maybe get, according to fake web service

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Route::get('pdf', 'StaticsController@pdf');