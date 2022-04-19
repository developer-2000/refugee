<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LocalizationProvider extends ServiceProvider
{
    // создать имя фасада и ссылку на service
    public function register()
    {
        $this->app->bind("Localization", 'App\Services\LocalizationService');
    }
}
