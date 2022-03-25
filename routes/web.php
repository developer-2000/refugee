<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/', 'IndexController@index')->name('index');
Route::get('language/{name}', 'LanguageController@changeLanguage');

//Route::get('country/{country}', 'CountryController@index')
//    ->where('country', '[a-z]+')->name('country.index');

Route::resource('country', 'CountryController')->only([
    'show'
]);


//    ->names([
//    'show' => 'country.show'
//]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
