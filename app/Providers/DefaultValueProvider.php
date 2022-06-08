<?php
namespace App\Providers;

use App\Model\RespondVacancy;
use App\Model\Vacancy;
use App\Repositories\RespondVacancyRepository;
use App\Repositories\VacancyRepository;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DefaultValueProvider extends ServiceProvider {

    public function register() { }

    public function boot()
    {
        View::composer('*', function ($view) {
            // языковое меню и префикс lang для url
            $lang = (new LanguageService())->getLanguageArray();
            // авторизованый user
            $user = Auth::user();
            // передает количество не прочтанных откликов на мои вакансии и резюме
            $respond = [
                "count_vacancies" => (new RespondVacancyRepository())->getCountRespondVacancies(new  VacancyRepository()),
                "count_resume" => 0
            ];

            $view->with(compact('lang','user', 'respond'));
        });
    }
}
