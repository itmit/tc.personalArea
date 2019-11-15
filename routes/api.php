<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('places', 'Api\PlaceApiController', [
    'only' => ['index', 'show']
]);

Route::resource('bidForBuy', 'Api\BidForBuyApiController', [
    'only' => ['index', 'create', 'store']
]);

Route::resource('bidForSale', 'Api\BidForSaleApiController', [
    'only' => ['index', 'create', 'store']
]);

Route::resource('news', 'Api\NewsApiController', [
    'only' => 'index'
]); // новости
Route::get('news/hourlyNews', 'Api\NewsApiController@getHourlyNews');

Route::get('places/{block}/{status}', 'Api\PlaceApiController@showPlacesInBlockWithStatus');

Route::post('place/check-valid-place-number', 'Api\PlaceApiController@checkValidPlaceNumber');

Route::post('place/makeReservation', 'Api\PlaceApiController@makeReservation');

Route::post('question/store', 'Api\QuestionApiController@store');

Route::post('admin/login', 'Api\AuthApiController@login');