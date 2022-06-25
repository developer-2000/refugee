<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Drip Interval
    |--------------------------------------------------------------------------
    | Здесь вы можете настроить интервал, с которым Caffeine for Laravel
    | сохраняет сеанс живым. По умолчанию это 5 минут (выраженное
    | в миллисекундах). Это должно быть короче, чем ваша сессия
    | значение времени жизни настроено в "config/session.php".
    |
    | Default: 300000 (int)
    | 1sec = 1000
    */
    'drip-interval' => 300000,

    /*
    |--------------------------------------------------------------------------
    | Domain
    |--------------------------------------------------------------------------
    | При желании вы можете настроить отдельный домен, который вы используете
    | Кофеин для Laravel включен. Это может быть интересно, если у вас есть
    | служба мониторинга, которая запрашивает другие приложения. Установка этого на
    | null будет использовать домен текущего приложения.
    |
    | Default: null (null|string)
    |
    */
    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Drip Endpoint URL
    |--------------------------------------------------------------------------
    | Иногда вы можете захотеть пометить свое приложение белой меткой и не раскрывать AJAX.
    | запрашивать URL-адреса как принадлежащие этому пакету. Чтобы добиться этого, вы можете
    | переименуйте URL-адрес, используемый для добавления кофеина в ваше приложение.
    |
    | Default: 'genealabs/laravel-caffeine/drip' (string)
    |
    */
    'route' => 'genealabs/laravel-caffeine/drip', // Customizable end-point URL

    /*
    |--------------------------------------------------------------------------
    | Checking for Lapsed Drips
    |--------------------------------------------------------------------------
    | Если браузер переведен в спящий режим (например, на мобильных устройствах или
    | ноутбуки), это все равно вызовет ошибку при попытке отправить
    | форма. Чтобы избежать этого, мы принудительно перезагружаем форму за 2 минуты до
    | до тайм-аута сеанса или позже. Установка этого параметра на 0
    | отключит эту проверку, если вы не хотите ее использовать.
    |
    | Default: 2000 (int)
    |
    */
    'outdated-drip-check-interval' => 2000,

    /*
    |--------------------------------------------------------------------------
    | Use Route Middleware
    |--------------------------------------------------------------------------
    | Капли включаются через промежуточное ПО маршрута вместо глобального промежуточного ПО.
    |
    | Default: false (bool)
    |
    */
    'use-route-middleware' => false,

];
