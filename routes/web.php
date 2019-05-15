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

Route::group(['as' => 'auth.', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::group(['as' => 'admin.', 'middleware' => ['role:super-admin']], function () {
        Route::get('/manager-list', ['as' => 'managerList', 'uses' => 'ManagerListController@index']);
        Route::get('/create-manager', ['as' => 'createManager', 'uses' => 'CreateManagerController@index']);

        Route::post('/create-manager', ['as' => 'createManagerHandler', 'uses' => 'CreateManagerController@createManager']);
    });

    Route::group(['as' => 'manager.', 'middleware' => ['role:super-admin|manager']], function () {
        Route::get('/place-list', ['as' => 'placeList', 'uses' => 'PlaceListController@index']);

    });
});

Auth::routes();