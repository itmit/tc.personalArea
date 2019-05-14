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
    Route::group(['as' => 'admin.', 'middleware' => ['role:super-admin']], function () {
        Route::get('/', ['as' => 'adminHome', 'uses' => 'HomeAdminController@index']);
        Route::get('/manager-list', ['as' => 'managerList', 'uses' => 'ManagerListController@index']);
        Route::get('/create-manager', ['as' => 'createManager', 'uses' => 'CreateManagerController@index']);

        Route::post('/create-manager', ['as' => 'createManagerHandler', 'uses' => 'CreateManagerController@createManager']);
    });

    Route::group(['as' => 'admin.', 'middleware' => ['role:super-admin|manager']], function () {

    });
});

Auth::routes();