<?php

use Illuminate\Support\Facades\Route;

//->middleware('auth:api')

// обращение через - /admin-panel
Route::namespace('Admin')->group( function () {

    Route::get('/', 'AdminController@accessPanel')->name('admin.index');

    // auth
    Route::prefix('auth')->group( function () {
        Route::post('sign-in', 'AdminController@signIn');
        Route::get('logout', 'AdminController@logout');
    });

    // только admin
    Route::group(['middleware' => ['only_admin']], function () {

        Route::namespace('Translate')->group( function () {
            Route::get('translate-countries', 'AdminTranslateCountryController@index');
            Route::post('translate-countries/update', 'AdminTranslateCountryController@update');
            Route::get('translate-regions', 'AdminTranslateRegionsController@index');
            Route::post('translate-regions/update', 'AdminTranslateRegionsController@update');
        });

    });

});





