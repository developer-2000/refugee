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

        Route::get('index', 'AdminCountryController@index');

    });
});





