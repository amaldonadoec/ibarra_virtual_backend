<?php

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

Route::group(['middleware' => []], function () {
    /* Category */
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'Api\CategoryController@index');
    });
    /* Site */
    Route::group(['prefix' => 'site'], function () {
        Route::get('/', 'Api\SiteController@index');
    });
});
