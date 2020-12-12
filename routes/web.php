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

Route::get('', 'Admin\HomeController@userMain')->name('user.main');
Route::get('user-offer-page', 'Admin\HomeController@userOfferPage')->name('user.offer');
Route::post('user-offer-page', 'Admin\HomeController@userOfferSubmit')->name('user.offer.submit');

Route::get('home', 'HomeController@index')->name('home');


Route::namespace('Admin')->group(function () {
    Route::resource('products', 'ProductController')->except('show');
    Route::get('products-offers-start', 'ProductController@productOfferStart')->name('offer.start');
    Route::get('products-offers-end', 'ProductController@productOfferEnd')->name('offer.end');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
