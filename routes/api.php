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

Route::resource('bid-for-buy', 'Api\BidForBuyApiController', [
    'only' => ['index', 'create', 'store']
]);

Route::resource('bid-for-sale', 'Api\BidForSaleApiController', [
    'only' => ['index', 'create', 'store']
]);

Route::resource('news-api', 'Api\NewsApiController'); // новости
Route::resource('purchase-requisition', 'Api\PurchaseRequisitionApiController');

Route::get('places/{block}/{status}', 'Api\PlaceApiController@showPlacesInBlockWithStatus');

Route::post('place/check-valid-place-number', 'Api\PlaceApiController@checkValidPlaceNumber');
