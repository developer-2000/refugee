#### localisation - формирование url функционирование переключения на строне Front

 * документация функционала в documents/localization url смена из фронта.doc

#### добавление пакета caffein

https://github.com/GeneaLabs/laravel-caffeine

#### package moment работа со временем в js
https://momentjs.com/

https://robert-askam.co.uk/posts/how-to-use-momentjs-in-vuejs-and-laravel-5


#### custom pagination laravel + vue.js
https://medium.com/introcept-hub/create-pagination-component-using-laravel-and-vue-js-e5709aac2724

#### переключатель bootstrap switch
https://gitbrent.github.io/bootstrap4-toggle/


#### Пакет стран и городов
https://github.com/MenaraSolutions/geographer-laravel

https://github.com/MenaraSolutions/geographer

В стране может не быть регионов и в регионе может не быть города

В случае поиска вакансии - предоставляю город или регион



#### tooltip подсказка bootstrap4
https://itchief.ru/bootstrap/tooltips

#### Редактор текста CKEditor 4 WYSIWYG Editor Vue
https://ckeditor.com/docs/ckeditor4/latest/guide/dev_vue.html

скачать и открыть /ckeditor/samples/index.html для визуального редактора выбора кнопок окно
https://ckeditor.com/cke4/release/CKEditor-4.5.0

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


