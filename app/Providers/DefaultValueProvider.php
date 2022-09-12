<?php
namespace App\Providers;

use App\Repositories\OfferRepository;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use function Symfony\Component\Translation\getLocale;

class DefaultValueProvider extends ServiceProvider {

    public function register() { }

    public function boot()
    {
        // создать префикс языка системы из url
        if (!Session::has('prefix_lang')) {
            $service = new LanguageService();
            $prefix_lang = $service->createSystemLanguageFromUrl();
            session(['prefix_lang' => $prefix_lang]);
        }

        View::composer('*', function ($view) {
            // языковое меню и префикс lang для url
            $lang = (new LanguageService())->getLanguageArray();
            // авторизованый user
            $user = Auth::user();
            // вернуть количество не прочитанных чатов
            $count_unread_chats = (new OfferRepository())->getCountUnreadChats();

            $view->with(compact('lang','user', 'count_unread_chats'));
        });
    }
}
