<?php
namespace App\Providers;

use App\Repositories\OfferRepository;
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
            // вернуть количество не прочитанных чатов
            $count_unread_chats = (new OfferRepository())->getCountUnreadChats();

            $view->with(compact('lang','user', 'count_unread_chats'));
        });
    }
}
