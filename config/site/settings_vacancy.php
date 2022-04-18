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
    // Вакансия подходит для: до 25 лет, от 25 до 40 лет, от 40 лет и старше, не важно
    // Индексы ключи к файлу языка
    'vacancy_suitable' => [
        'it_not_matter',
        ['set_age' => [ 'from', 'to' ]],
        'age_comment',
    ],
    // Какие контакты связи показать соискателю: email, tel, messenger viber, messenger telegram,
    // Индексы ключи к файлу языка
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
    // перечень категорий вакансий
    // Индексы ключи к файлу языка
    'categories' => [
        'internet','administration','accounting','hotel','design','beauty','culture','logistics','marketing','medicine',
        'real_estate','education','security','sales','working','retail','secretariat','agriculture','media',
        'insurance','construction','service_sector','telecommunications','top_management','transport','personnel_management',
        'finance','jurisprudence','other'
    ],

];
























