<?php

use Illuminate\Support\Facades\Route;
use \App\Services\LocalizationService;

// технический роут
Route::group(['prefix'=>'technical'], function (){
    // /technical/artisan/clear_all
    Route::get('/artisan/{cmd}', function($cmd) {
        $cmd = trim(str_replace("-",":", $cmd));
        $validCommands = [
            'optimize',
            'route:cache',
            'route:clear',
            'view:clear',
            'config:cache',
            'config:clear',
            'cache:clear'
        ];
        if ($cmd == 'clear_all'){
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            return "<h1>all_clear</h1>";
        }
        else {
            return "<h1>Not valid Artisan command</h1>";
        }
    });

    // /technical/load-location-db
    Route::get('/load-location-db', function () {
        (new \App\Services\MakeLocationDbServices());
        return view('index');
    });
});

Route::group([
    // переключение url и translation сайта
    'prefix' => Localization::locale(),
], function () {

    Route::get('/', 'IndexController@index')->name('index');

//    Route::get('/job-search/{country?}/{region?}/{city?}', 'SearchVacancyController@jobSearch');
    Route::resource('job-search', 'SearchVacancyController')->only([
        'index',
    ]);

    // Auth
    Route::middleware('throttle:10,1')->group(function () {
        Route::group(['namespace' => 'Auth', 'prefix'=>'user'], function (){
            Route::post('/login', 'AuthorController@login');
            Route::post('/registration', 'AuthorController@register');
            Route::post('/check_email', 'AuthorController@checkEmail');
            Route::post('/send-code-password', 'AuthorController@sendCodeForChangePassword');
            Route::post('/change-password', 'AuthorController@changePassword');
            Route::get('/activate', 'AuthorController@activateAccount');
            Route::get('/view-change-password', 'AuthorController@viewChangePassword');
            Route::get('/logout', 'AuthorController@logout');
        });
    });

    Route::group(['middleware'=>['auth']], function () {
        Route::group(['prefix'=>'private-office'], function (){

            Route::get('/', 'PrivateOfficeController@index');

            // vacancies
            Route::group(['prefix'=>'vacancy'], function (){
                Route::post('search-vacancy', 'VacancyController@searchVacancy');
                Route::get('my-vacancies', 'VacancyController@myVacancies');
                Route::post('up-vacancy-status', 'VacancyController@upVacancyStatus');
                Route::post('duplicate-vacancy', 'VacancyController@duplicateVacancy');
                Route::post('bookmark-vacancy', 'VacancyController@bookmarkVacancy');
                Route::post('hide-vacancy-search', 'VacancyController@hideVacancyInSearch');
            });
            Route::resource('vacancy', 'VacancyController')->only([
                'create', 'store', 'destroy', 'edit', 'update',
            ]);
        });
    });

    // select localisation
    Route::group(['prefix'=>'localisation'], function (){
        Route::post('/get-region', 'CountryController@getRegion');
        Route::post('/get-city', 'CountryController@getCity');
    });

    // change language
    Route::get('language/{name}', 'LanguageController@changeLanguage')->name('language');

    Route::resource('country', 'CountryController')->only([
        'show'
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
