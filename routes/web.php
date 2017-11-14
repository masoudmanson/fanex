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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('index');

Route::get('/about', 'StaticsController@about');
Route::get('/terms', 'StaticsController@terms');
Route::get('/contact', 'StaticsController@contact')->name('contact');
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

Route::post('/invoice', 'PaymentController@issueInvoice')->name('issue_invoice');
Route::get('/invoice/show', 'PaymentController@showInvoice')->name('show_invoice');

Route::get('/send/{beneficiary}', 'UserController@sendMoney');

Route::resource('/additional-info', 'UserInformationController');
Route::any('/beneficiary/select', 'BeneficiaryController@createOrSelect')->name('createOrSelect');
Route::post('/proforma', 'PaymentController@proforma_with_new_bnf')->name('proforma_with_new_bnf');
Route::get('/proforma/selected/{beneficiary}', 'PaymentController@proforma_with_selected_bnf_profile')->name('proforma_with_selected_bnf_profile');
Route::get('/proforma/transaction/{transaction}', 'PaymentController@proforma_with_selected_transaction')->name('proforma_with_transaction');
Route::get('/proforma/selected', 'PaymentController@proforma_with_selected_bnf')->name('proforma_with_selected_bnf');

Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'flat') {
    return $captcha->src($config);
});

Route::post('/calculate', 'UptController@calculateRemittance')->name('calculate'); //maybe get, according to fake web service

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Route::get('pdf/proforma/{id}', 'StaticsController@proformaPdf');

Route::any('/search/beneficiary', 'BeneficiaryController@search');
Route::any('/search/transaction', 'UserController@search');

Route::get('/search/beneficiary/country/{country}', 'BeneficiaryController@searchCountry');
Route::get('/search/transaction/status/{status}', 'UserController@searchStatus');

Route::get('/transaction/status/update/{transaction}','UserController@update_transaction_status');
