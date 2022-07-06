<?php


use Illuminate\Support\Facades\Route;
//->middleware('auth:api')
Route::namespace('Admin')->group( function () {

    Route::get('/', function () {
        return 'Hello World';
    });

    Route::prefix('language')->group( function () {
        // заменить язык на сервере
//        Route::post('change_language', 'LanguageAdminController@changeLanguage');
    });


    Route::prefix('auth')->group( function () {
        // создать админа и выслать сообщение на Email для продолжения регистрации
//        Route::post('signup_admin', 'AuthAdminController@signupAdmin');
    });

});

// ===========================================
// ===========================================
// БЕЗ АВТОРИЗАЦИИ
Route::namespace('Admin')->group( function () {
    // 1 Auth
    Route::prefix('auth')->group( function () {
        // продолжение регистрации админа
//        Route::post('continue_signup_admin', 'AuthAdminController@continueSignup');
    });
});



