<?php

use Illuminate\Support\Facades\Route;
use \App\Facades\LocalizationFacades;
use \App\Http\Controllers\Auth\GoogleController;
use \App\Http\Controllers\Auth\FacebookController;
use \App\Http\Controllers\Auth\LinkedinController;
use \App\Http\Controllers\Auth\TwitterController;
use \App\Http\Controllers\PoliceController;
use \App\Http\Controllers\IndexController;
use \App\Http\Controllers\CharityController;
use \App\Http\Controllers\OfferController;
use \App\Http\Controllers\ResumeController;
use \App\Http\Controllers\RespondController;
use \App\Http\Controllers\Auth\AuthorController;
use \App\Http\Controllers\OfferArchiveController;
use \App\Http\Controllers\CronController;
use \App\Http\Controllers\VacancyController;

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

    // url - /technical/...
    // run queue:work default
    Route::get('/run-job-default', [CronController::class, 'runJobDefault']);
    // run queue:work emails
    Route::get('/run-job-emails', [CronController::class, 'runJobEmails']);
    // псевдо проверка админом и активация документа
    Route::get('/pseudo-check-by-admin-documents', [CronController::class, 'pseudoCheckByAdminAndShowDocument']);
    // Деактивировать устаревшие документы
    Route::get('/deactivate_old_documents', [CronController::class, 'deactivateOldDocuments']);
});

// переключение url и translation сайта 'middleware' => ['redirect_admin']
Route::group(['prefix' => LocalizationFacades::locale()], function () {
    Route::group([], function () {

        Route::get('/', [IndexController::class, 'index'])->name('index');

        // Authentication
        Route::middleware('throttle:10,1')->group(function () {
            Route::group(['namespace' => 'Auth', 'prefix'=>'user'], function (){
                Route::post('/login', [AuthorController::class, 'login']);
                Route::post('/registration', [AuthorController::class, 'register']);
                Route::post('/check_email', [AuthorController::class, 'checkEmail']);
                Route::post('/send-code-password', [AuthorController::class, 'sendCodeForChangePassword']);
                Route::post('/change-password', [AuthorController::class, 'changePassword']);
                Route::get('/activate', [AuthorController::class, 'activateAccount']);
                Route::get('/view-change-password', [AuthorController::class, 'viewChangePassword']);
                Route::get('/logout', [AuthorController::class, 'logout']);
                // google
                Route::get('/google/redirect', [GoogleController::class, 'redirect']);
                Route::get('/google/callback', [GoogleController::class, 'callback']);
                // facebook
                Route::get('/facebook/redirect', [FacebookController::class, 'redirect']);
                Route::get('/facebook/callback', [FacebookController::class, 'callback']);
                // linkedin
                Route::get('/linkedin/redirect', [LinkedinController::class, 'redirect']);
                Route::get('/linkedin/callback', [LinkedinController::class, 'callback']);
                // twitter
                Route::get('/twitter/redirect', [TwitterController::class, 'redirect']);
                Route::get('/twitter/callback', [TwitterController::class, 'callback']);
            });
        });

        // company
        Route::get('/company/{alias}', 'CompanyController@show')
            ->where('alias', '[0-9a-z_-]+');

        // авторизованым
        Route::group(['middleware'=>['auth']], function () {

            // respond vacancy
            Route::post('respond-vacancy', [RespondController::class, 'respondVacancy']);
            // respond resume
            Route::post('respond-resume', [RespondController::class, 'respondResume']);

            // архив чатов
            Route::group(['prefix'=>'offers/archive'], function (){
                Route::get('/', [OfferArchiveController::class, 'index']);
                Route::post('add-message', [OfferArchiveController::class, 'addMessage']);
                Route::get('/{alias}', 'OfferArchiveController@show')
                    ->where('alias', '[a-z0-9]+')->name('archive.show');
            });
            // чаты предложений
            Route::post('offers/search-name-position', [OfferController::class, 'searchNamePosition']);
            Route::post('offers/add-message', [OfferController::class, 'addMessage']);
            Route::post('offers/register-viewed-companion', [OfferController::class, 'registerViewedCompanion']);
            Route::post('offers/update-message', [OfferController::class, 'updateMessage']);
            Route::post('offers/delete', [OfferController::class, 'destroy']);
            Route::post('offers/send-to-archive', [OfferController::class, 'sendToArchive']);
            Route::get('offers/{alias}', [OfferController::class, 'show'])
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
                    Route::post('bookmark-vacancy', 'VacancyController@setBookmarkVacancy');
                    Route::get('bookmark-vacancies', 'VacancyController@getBookmarkVacancies');
                    Route::post('hide-vacancy', 'VacancyController@setHideVacancy');
                    Route::get('hidden-vacancies', 'VacancyController@getHiddenVacancies');
                });
                Route::resource('vacancy', 'VacancyController')->only([
                    'create', 'store', 'edit', 'update'
                ]);

                // resume
                Route::group(['prefix'=>'resume'], function (){
                    Route::post('search-position', [ResumeController::class, 'searchPosition']);
                    Route::get('my-resumes', [ResumeController::class, 'myResumes']);
                    Route::post('up-resume-status', [ResumeController::class, 'upResumeStatus']);
                    Route::post('duplicate-resume', [ResumeController::class, 'duplicateResume']);
                    Route::post('bookmark-resume', [ResumeController::class, 'setBookmarkResume']);
                    Route::get('bookmark-resumes', [ResumeController::class, 'getBookmarkResumes']);
                    Route::post('hide-resume', [ResumeController::class, 'setHideResume']);
                    Route::get('hidden-resumes', [ResumeController::class, 'getHiddenResumes']);
                });
                Route::resource('resume', 'ResumeController')->only([
                    'create', 'store', 'edit', 'update'
                ]);
            });

        });

        // vacancies
        Route::get('/vacancy/{prefix_c}/{prefix_r_c}/{alias}', [VacancyController::class, 'show']);
        Route::get('/vacancy/{country?}/{city?}', [VacancyController::class, 'index']);

        // resume
        Route::get('/resume/{prefix_c}/{prefix_r_c}/{alias}', [ResumeController::class, 'show']);
        Route::get('/resume/{country?}/{city?}', [ResumeController::class, 'index']);

        // localisation
        Route::group(['prefix'=>'localisation'], function (){
            Route::post('/get-region', 'GeographyDbController@getRegions');
            Route::post('/get-city', 'GeographyDbController@getCities');
        });

        // change language
        Route::get('language/{name}', 'LanguageController@changeLanguage')
            ->name('language');

        // общие страницы
        Route::get('cookie-police', [PoliceController::class, 'showCookiePage']);
        Route::get('terms-use', [PoliceController::class, 'showTermsUsePage']);
        Route::get('about-us', [IndexController::class, 'aboutUs'])
            ->name('about-us');
        Route::get('feedback', [IndexController::class, 'feedback'])
            ->name('feedback');
        Route::post('feedback-send-message', [IndexController::class, 'feedbackSendMessage']);
        Route::get('show-charity', [CharityController::class, 'showCharity'])
            ->name('show-charity');

    });
});
