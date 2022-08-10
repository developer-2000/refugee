#### микроразметка примеры
https://freehost.com.ua/ukr/faq/articles/chto-takoe-mikrorazmetka-ee-vidi-funktsii-primeri-realizatsii/?gclid=Cj0KCQjwio6XBhCMARIsAC0u9aGp3uF2iLXSQdF1s-z8ojsoCG30eLT4G0Yk5AplqZZ4FqIWQEE5lmIaAifTEALw_wcB

https://d-element.ru/about/blog/chto-takoe-schema-org/#wpheader

#### авторизация через пакет socialite

https://laravel.su/docs/8.x/socialite

help video - https://www.youtube.com/watch?v=cXbgZhOS72w&list=PLfViXxbdy6QjbnKsMJ8QpSBH36gLxcci6

help настроек - https://blog.ithillel.ua/ru/articles/oauth-2-0-autentifikatsiya-cherez-google-kak-realizovat-vhod-cherez-google-na-sayte

###### страница настроек google 
https://console.cloud.google.com/apis/credentials?highlightClient=890676224339-h89hv5apvt4rroi3rb8d6k38fpu1vg64.apps.googleusercontent.com&project=engaged-hook-358914

после сменить домен на рабочий D:\ystanovki\OpenServer_5.3.8\domains\refugee\config\services.php

'redirect' => 'http://localhost:8000/user/google/callback',

###### страница настроек facebook

https://developers.facebook.com/apps/427327926024607/settings/basic/



#### пакет для мета тегов сайта
https://github.com/butschster/LaravelMetaTags

#### localisation - формирование url функционирование переключения на стороне Front

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


