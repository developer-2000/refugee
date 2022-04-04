<?php

use Illuminate\Support\Facades\Route;

// технический роут
Route::group(['prefix'=>'technical'], function (){
    // /artisan/clear_all
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


Route::group([ 'middleware' => ['locale'] ], function () {

    Route::get('/', 'IndexController@index')->name('index');

    Route::get('language/{name}', 'LanguageController@changeLanguage');

//    Route::middleware('throttle:3,1')->group(function () {
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
//    });





//    vacancy

    Route::resource('country', 'CountryController')->only([
        'show'
    ]);
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
