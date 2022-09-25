<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\Translate\AdminTranslateCountryController;
use \App\Http\Controllers\Admin\Translate\AdminTranslateRegionsController;
use \App\Http\Controllers\Admin\Translate\AdminTranslateCitiesController;
use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Admin\Documents\AdminVacanciesController;
use \App\Http\Controllers\Admin\AdminUserController;

//->middleware('auth:api')

// обращение через - /admin-panel
Route::namespace('Admin')->group( function () {

    Route::get('/', [AdminController::class, 'accessPanel'])->name('admin.index');

    // auth
    Route::prefix('auth')->group( function () {
        Route::post('sign-in', [AdminController::class, 'signIn']);
        Route::get('logout', [AdminController::class, 'logout']);
    });

    // только admin
    Route::group(['middleware' => ['only_admin']], function () {
        // translate location
        Route::namespace('Translate')->group( function () {
            Route::get('translate-countries', [AdminTranslateCountryController::class, 'index']);
            Route::post('translate-countries/update', [AdminTranslateCountryController::class, 'update']);
            Route::get('translate-regions', [AdminTranslateRegionsController::class, 'index']);
            Route::post('translate-regions/update', [AdminTranslateRegionsController::class, 'update']);
            Route::get('translate-cities', [AdminTranslateCitiesController::class, 'index']);
            Route::post('translate-cities/update', [AdminTranslateCitiesController::class, 'update']);
        });
        // вакансии/резюме
        Route::group(['namespace' => 'Documents', 'prefix'=>'vacancies'], function (){
            Route::get('/', [AdminVacanciesController::class, 'index']);
            Route::post('verified-by-admin', [AdminVacanciesController::class, 'verifiedByAdmin']);
        });
        // Пользователи
        Route::group(['prefix'=>'users'], function (){
            Route::get('/', [AdminUserController::class, 'index']);
            Route::post('set-punished', [AdminUserController::class, 'setPunished']);
        });
    });

});
