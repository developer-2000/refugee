<?php

return [
    // Вид занятости: полная, неполная, удаленная работа
    // Индексы ключи к файлу языка
    'type_employment' => [
        'locally_full_time',
        'locally_part_time',
        'remote_full_time',
        'remote_part_time',
    ],
    // Вид занятости: Диапазон, Одно значение, Не указывать
    // Время оплаты: в час, в месяц
    // Индексы ключи к файлу языка
    'salary' => [
        'range' => [ 'from','to' ],
        'single_value' => [ 'salary_sum' ],
        'dont_specify' => [],
        'salary_comment' => [],
    ],
    // Опыт работы: без опыта, от 1 года, от 2 лет, от 5 лет,
    // Индексы ключи к файлу языка
    'work_experience' => [
        'without_experience',
        'from_1_year',
        'from_2_years',
        'from_5_years',
    ],
    // Образование: не имеет значения, высшее, неоконченное высшее, среднее специальное, среднее,
    // Индексы ключи к файлу языка
    'education' => [
        'does_not_matter',
        'secondary',
        'specialized_secondary',
        'incomplete_higher',
        'higher',
    ],
    // Возраст соискателя: не имеет значения, от 25 до 40 лет, возможен коммент
    // Индексы ключи к файлу языка
    'vacancy_suitable' => [
        'it_not_matter',
        ['set_age' => [ 'from', 'to' ]],
        'age_comment',
    ],
    // Какие контакты связи показать соискателю: email, tel, messenger viber, messenger telegram,
    'contact_information' => [
        'Email',
        'Mobile tell.',
        'Telegram',
        'Viber',
        'WhatsApp',
    ],
    // Как можно откликнуться: Резюме обязательно, Можно без резюме
    // Индексы ключи к файлу языка
    'how_respond' => [
        'resume_required',
        'without_resume',
    ],
    // статус вакансии - стандарт, скрытая
    // Индексы ключи к файлу языка
    'job_status' => [
        'standard',
        'hidden',
    ],

    // сколько в днях живет статус документа
    'lifetime_days_job_status' => [
        'standard' => 30,
        'hidden' => 0,
    ],

//    пират
// <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 128c0 44.4-25.4 83.5-64 106.4V256c0 17.7-14.3 32-32 32H208c-17.7 0-32-14.3-32-32V234.4c-38.6-23-64-62.1-64-106.4C112 57.3 176.5 0 256 0s144 57.3 144 128zM200 176c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32zm144-32c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32zM35.4 273.7c7.9-15.8 27.1-22.2 42.9-14.3L256 348.2l177.7-88.8c15.8-7.9 35-1.5 42.9 14.3s1.5 35-14.3 42.9L327.6 384l134.8 67.4c15.8 7.9 22.2 27.1 14.3 42.9s-27.1 22.2-42.9 14.3L256 419.8 78.3 508.6c-15.8 7.9-35 1.5-42.9-14.3s-1.5-35 14.3-42.9L184.4 384 49.7 316.6c-15.8-7.9-22.2-27.1-14.3-42.9z"/></svg>

];
























