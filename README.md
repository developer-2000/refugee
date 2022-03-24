#### Передача данных во все blade шаблоны
\app\Providers\ComposerServiceProvider.php

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('lang', 'text');
        });
    }
