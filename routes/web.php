<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'IndexController@index')->name('index');

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
