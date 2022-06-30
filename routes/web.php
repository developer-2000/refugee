<?php

use Illuminate\Support\Facades\Route;
use \App\Services\LocalizationService;

//<a href="{{ route('index') }}">111</a>
//<a class="dropdown-item" :href="`${lang.prefix_lang}vacancy`">Найти вакансию</a>

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

    // Authentication
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

    // vacancy
    Route::resource('vacancy', 'VacancyController')->only([
        'index', 'show',
    ]);

    // resume
    Route::resource('resume', 'ResumeController')->only([
        'index', 'show',
    ]);

    // company
    Route::get('/company/{alias}', 'CompanyController@show')
        ->where('alias', '[0-9a-z_-]+');

    // Auth
    Route::group(['middleware'=>['auth']], function () {

        // respond vacancy
        Route::post('respond-vacancy', 'RespondController@respondVacancy');
        // respond resume
        Route::post('respond-resume', 'RespondController@respondResume');

        // архив чатов
        Route::group(['prefix'=>'offers/archive'], function (){
            Route::get('/', 'OfferArchiveController@index');
            Route::post('add-message', 'OfferArchiveController@addMessage');
            Route::get('/{alias}', 'OfferArchiveController@show')
                ->where('alias', '[a-z0-9]+')->name('archive.show');
        });
        // чаты предложений
        Route::post('offers/search-name-position', 'OfferController@searchNamePosition');

        Route::post('offers/add-message', 'OfferController@addMessage');

        Route::post('offers/register-viewed-companion', 'OfferController@registerViewedCompanion');
        Route::post('offers/update-message', 'OfferController@updateMessage');
        Route::post('offers/delete', 'OfferController@destroy');
        Route::post('offers/send-to-archive', 'OfferController@sendToArchive');
        Route::get('offers/{alias}', 'OfferController@show')
            ->where('alias', '[a-z0-9]+');
        Route::resource('offers', 'OfferController')->only([
            'index'
        ]);



        // private-office
        Route::group(['prefix'=>'private-office'], function (){

            // office
            Route::get('/', 'PrivateOfficeController@index');

            // Contact Information
            Route::group(['prefix'=>'contact-information'], function (){
                Route::get('/', 'ContactInformationController@index');
                Route::post('update', 'ContactInformationController@update');
            });

            // company
            Route::group(['prefix'=>'company'], function (){
                Route::post('update', 'CompanyController@update');
                Route::post('check-transliteration', 'CompanyController@checkTransliteration');
            });
            Route::resource('company', 'CompanyController')->only([
                'create', 'store'
            ]);

            // vacancies
            Route::group(['prefix'=>'vacancy'], function (){
                Route::post('search-position', 'VacancyController@searchPosition');
                Route::get('my-vacancies', 'VacancyController@myVacancies');
                Route::post('up-vacancy-status', 'VacancyController@upVacancyStatus');
                Route::post('duplicate-vacancy', 'VacancyController@duplicateVacancy');
                Route::post('bookmark-vacancy', 'VacancyController@bookmarkVacancy');
                Route::get('bookmark-vacancies', 'VacancyController@bookmarkVacancies');
                Route::post('hide-vacancy', 'VacancyController@hideVacancy');
                Route::get('hidden-vacancies', 'VacancyController@hiddenVacancies');
            });
            Route::resource('vacancy', 'VacancyController')->only([
                'create', 'store', 'edit', 'update'
            ]);

            // resume
            Route::group(['prefix'=>'resume'], function (){
                Route::post('search-position', 'ResumeController@searchPosition');
                Route::get('my-resumes', 'ResumeController@myResumes');
                Route::post('up-resume-status', 'ResumeController@upResumeStatus');
                Route::post('duplicate-resume', 'ResumeController@duplicateResume');
                Route::post('bookmark-resume', 'ResumeController@bookmarkResume');
                Route::get('bookmark-resumes', 'ResumeController@bookmarkResumes');
                Route::post('hide-resume', 'ResumeController@hideResume');
                Route::get('hidden-resumes', 'ResumeController@hiddenResumes');
            });
            Route::resource('resume', 'ResumeController')->only([
                'create', 'store', 'edit', 'update'
            ]);
        });

    });

    // localisation
    Route::group(['prefix'=>'localisation'], function (){
        Route::post('/get-region', 'MakeGeographyDbController@getRegion');
        Route::post('/get-city', 'MakeGeographyDbController@getCity');
    });

    // change language
    Route::get('language/{name}', 'LanguageController@changeLanguage')
        ->name('language');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
