<?php
namespace App\Providers;

use App\Services\LanguageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Передача данных во все шаблоны
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            // языковое меню
            $lang = (new LanguageService())->getLanguageArray();
            $user = Auth::user();

            $view->with(compact('lang','user'));
        });
    }
}
