<?php

return [
    // Вид занятости: полная, неполная, удаленная работа
    // Индексы ключи к файлу языка
    'type_employment' => [
        'complete',
        'incomplete',
        'remote_work',
    ],
    // Вид занятости: Диапазон, Одно значение, Не указывать
    // Время оплаты: в час, в месяц
    // Индексы ключи к файлу языка
    'salary' => [
        'options' => [ 'range','one_value','do_not_specify' ],
        'payment_time' => [ 'per_hour','per_month' ],
    ],
    // Время оплаты: без опыта, от 1 года, от 2 лет, от 5 лет,
    // Индексы ключи к файлу языка
    'work_experience' => [
        'without_experience',
        'from_1_year',
        'from_2_years',
        'from_5_years',
    ],
];
