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


use Illuminate\Support\Facades\Route;

Route::group(['as' => 'auth.', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::group(['as' => 'admin.', 'middleware' => ['role:super-admin']], function () {
        Route::resource('managers', 'Web\ManagerController', [
            'only' => ['index', 'create', 'store']
        ]);
    });

    Route::group(['as' => 'manager.', 'middleware' => ['role:super-admin|manager']], function () {

        Route::resource('places', 'Web\PlaceController', [
            'only' => ['index', 'create', 'store', 'destroy', 'getPlacesByBlock']
        ]);

        Route::post('places/getPlacesByBlock', 'Web\PlaceController@getPlacesByBlock');
        
        Route::delete('places/delete', 'Web\PlaceController@destroy');

        Route::post('places/import', 'Web\PlaceController@importFromExcel')->name('places.import');

        Route::resource('news', 'Web\NewsController', [
            'only' => ['index', 'create', 'store']
        ]);

        Route::resource('bidForSale', 'Web\BidForSaleController', [
            'only' => ['index', 'create', 'store']
        ]);

        Route::resource('bidForBuy', 'Web\BidForBuyWebController', [
            'only' => ['index', 'create', 'store']
        ]);

        Route::resource('reservation', 'Web\ReservationWebController', [
            'only' => ['index', 'create', 'store']
        ]);

        Route::post('reservation/confirmReservation', 'Web\ReservationWebController@confirmReservation');
        Route::post('reservation/selectByAccept', 'Web\ReservationWebController@selectByAccept');
    });
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
