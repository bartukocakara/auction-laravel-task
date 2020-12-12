<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('', 'Admin\OfferController@userMain')->name('user.main');
Route::get('user-offer-page/{id}', 'Admin\OfferController@userOfferPage')->name('user.offer');
Route::post('user-offer-page/{id}', 'Admin\OfferController@userOfferSubmit')->name('user.offer.submit');

Route::get('home', 'HomeController@index')->name('home');


Route::namespace('Admin')->group(function () {
    Route::resource('products', 'ProductController')->except('show');
    Route::get('products-offers-start', 'ProductController@productOfferStart')->name('offer.start');
    Route::get('products-offers-ended', 'ProductController@productOfferEnd')->name('offer.end');
});
