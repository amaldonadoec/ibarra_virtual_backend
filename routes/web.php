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

Route::get('/api/img/{path}', 'Multimedia\ImageController@show')->where('path', '.*');

Auth::routes();
Route::group(['middleware' => ['auth', 'rbac']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'rbac', 'namespace' => 'Rbac'], function () {
        Route::group(['prefix' => 'role'], function () {
            Route::get('role', 'RoleController@index');
            Route::get('index', 'RoleController@index');
            Route::get('form', 'RoleController@getFormRole');
            Route::get('form/{id?}', 'RoleController@getFormRole');
            Route::get('list', 'RoleController@getList');
            Route::get('list/select', 'RoleController@getListSelect2');
            Route::post('unique-name', 'RoleController@postIsNameUnique');
            Route::post('save', 'RoleController@postSave');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@index');
            Route::get('index', 'UserController@index');
            Route::get('form', 'UserController@getForm');
            Route::get('form/{id?}', 'UserController@getForm');
            Route::get('list', 'UserController@getList');
            Route::post('unique-email', 'UserController@postIsEmailUnique');
            Route::post('unique-name', 'UserController@postIsNameUnique');
            Route::post('save', 'UserController@postSave');
        });
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'Catalogs\CategoryController@index');
        Route::get('/form', 'Catalogs\CategoryController@getFormCategory');
        Route::get('/form/{id?}', 'Catalogs\CategoryController@getFormCategory');
        Route::get('/list', 'Catalogs\CategoryController@getListCategories');
        Route::get('/list/select', 'Catalogs\CategoryController@getListSelect2');
        Route::post('/unique-name', 'Catalogs\CategoryController@postIsNameUnique');
        Route::post('/save', 'Catalogs\CategoryController@postSave');
    });

    Route::group(['prefix' => 'sites'], function () {
        Route::get('/', 'Catalogs\SiteController@index');
        Route::get('/form', 'Catalogs\SiteController@getForm');
        Route::get('/form/{id?}', 'Catalogs\SiteController@getForm');
        Route::get('/list', 'Catalogs\SiteController@getList');
        Route::post('/unique-name', 'Catalogs\SiteController@postIsNameUnique');
        Route::post('/save', 'Catalogs\SiteController@postSave');
    });

});
