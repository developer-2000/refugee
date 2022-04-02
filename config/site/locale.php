<?php

return [

    'languages' => [
        /*
          * Ключ - код локали Laravel
          * Индекс 0 под-массива - код языка Carbon
          * Индекс 1 подмассива - это код локали PHP для setlocale ()
          * Индекс 2 подмассива указывает, использовать ли RTL (справа налево) CSS для этого языка
         */
        'en'    => ['en', 'en_US', false, [ 'alias' => 'en', 'title' => 'English', 'avatar' => '/img/custom/US.png' ], ],
        'ru'    => ['ru', 'ru-RU', false, [ 'alias' => 'ru', 'title' => 'Русский', 'avatar' => '/img/custom/RU.png' ], ],
        'uk'    => ['uk', 'uk_UA', false, [ 'alias' => 'uk', 'title' => 'Український', 'avatar' => '/img/custom/UA.png' ], ],
    ],
];
