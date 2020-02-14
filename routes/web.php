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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'auth.', 'middleware' => 'auth'], function () {

    Route::get('/', 'Web\NewsController@index');

    Route::group(['as' => 'admin.', 'middleware' => ['role:super-admin']], function () {
        // Route::get('/', 'Web\WasteWebController@index');
        Route::resource('managers', 'Web\ManagerController');
        Route::get('managers/edit/{id}', 'Web\ManagerController@managerEditPage');
        Route::resource('managerswaste', 'Web\ManagerWasteWebController');
    });

    Route::group(['as' => 'managerwaste.', 'middleware' => ['role:manager-waste|super-admin']], function () {
        // Route::get('/', 'Web\WasteWebController@index');
        Route::resource('wastes', 'Web\WasteWebController');
        Route::post('wastes/selectByBlock', 'Web\WasteWebController@selectByBlock');
    });

    Route::group(['as' => 'manager.', 'middleware' => ['role:super-admin|manager']], function () {
        // Route::get('/', 'Web\WasteWebController@index');
        Route::resource('places', 'Web\PlaceController', [
            'only' => ['index', 'create', 'store', 'destroy', 'getPlacesByBlock']
        ]);

        Route::resource('wastes', 'Web\WasteWebController');
        Route::post('wastes/selectByBlock', 'Web\WasteWebController@selectByBlock');

        Route::post('places/getPlacesByBlock', 'Web\PlaceController@getPlacesByBlock');
        Route::post('places/changePlaceStatus', 'Web\PlaceController@changePlaceStatus');
        Route::get('place/edit/{id}', 'Web\PlaceController@placeEditPage')->name('place.edit');
        Route::post('place/edit/store', 'Web\PlaceController@placeEditStore')->name('place.store');
        
        Route::delete('places/delete', 'Web\PlaceController@destroy');

        Route::post('places/import', 'Web\PlaceController@importFromExcel')->name('places.import');
        Route::post('places/makeAllRent', 'Web\PlaceController@makeAllRent');

        Route::resource('news', 'Web\NewsController');

        Route::resource('bidForSale', 'Web\BidForSaleController');
        Route::post('bidForSale/changeBidStatus', 'Web\BidForSaleController@changeBidStatus');
        Route::post('bidForSale/selectByType', 'Web\BidForSaleController@selectByType');


        // Route::delete('bidForSale/delete', 'Web\BidForSaleController@destroy');

        Route::resource('bidForBuy', 'Web\BidForBuyWebController');
        Route::post('bidForBuy/changeBidStatus', 'Web\BidForBuyWebController@changeBidStatus');
        Route::post('bidForBuy/selectByType', 'Web\BidForBuyWebController@selectByType');

        // Route::delete('bidForBuy/delete', 'Web\BidForBuyWebController@destroy');

        Route::resource('reservation', 'Web\ReservationWebController', [
            'only' => ['index', 'create', 'store', 'show']
        ]);

        // Route::resource('questions', 'Web\QuestionWebController');
        Route::get('assignment', 'Web\QuestionWebController@assignmentIndex')->name('assignment');
        Route::get('acquisition', 'Web\QuestionWebController@acquisitionIndex')->name('acquisition');
        Route::get('assignment/{id}', 'Web\QuestionWebController@show');
        Route::get('acquisition/{id}', 'Web\QuestionWebController@show');
        Route::post('assignment/changeBidStatus', 'Web\QuestionWebController@changeBidStatus');
        Route::post('acquisition/changeBidStatus', 'Web\QuestionWebController@changeBidStatus');

        Route::post('questions/selectByType', 'Web\QuestionWebController@selectByType');


        Route::post('questions/selectByType', 'Web\QuestionWebController@selectByType');

        Route::post('reservation/confirmReservation', 'Web\ReservationWebController@confirmReservation');
        Route::post('reservation/selectByAccept', 'Web\ReservationWebController@selectByAccept');
        Route::post('reservation/deleteReservation', 'Web\ReservationWebController@deleteReservation');
        Route::post('reservation/cancelReservation', 'Web\ReservationWebController@cancelReservation');

        Route::post('reservation/changeReservationStatus', 'Web\ReservationWebController@changeReservationStatus');

        Route::resource('client', 'Web\ClientWebController');
    });
    Route::group(['as' => 'all.', 'middleware' => ['role:super-admin|manager|manager-waste']], function () {
        Route::post('wastes/createExcelFile', 'Web\WasteWebController@createExcelFile');
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

Route::view('/privacy', 'privacy');
