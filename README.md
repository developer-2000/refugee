#### Передача данных во все blade шаблоны
\app\Providers\ComposerServiceProvider.php

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('lang', 'text');
        });
    }

#### Пакет стран и городов
https://github.com/MenaraSolutions/geographer-laravel


#### Laravel на русском
https://laravel.su/docs/6.x/redirects

#### vue.js на русском
https://ru.vuejs.org/v2/guide/index.html
#### Подгрузка перевода строк в vue.js
 * создать файл перевода в Laravel

    \resources\lang\en\menu\top.php

 * добавить путь к файлу с переводом в настройки пакета

    \config\localization-js.php

    'messages' => [ 'menu/top' ],

 * выполнить команду добавления переводов

    \resources\js\vue-translations.js

    php artisan lang:js --quiet --no-lib

 * создал метод для вывода записи перевода

    \resources\js\mixins\translation.js

 * вывод строки в html
 
    {{ trans('menu.top','authorization') }}


