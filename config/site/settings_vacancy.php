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
        'higher',
        'incomplete_higher',
        'specialized_secondary',
        'secondary',
    ],
    // Вакансия подходит для: до 25 лет, от 25 до 40 лет, от 40 лет и старше, не важно
    // Индексы ключи к файлу языка
    'vacancy_suitable' => [
        'up_to_25_years_old',
        'from_25_to_40_years_old',
        'from_40_years_old_and_older',
        'it_not_matter',
        'your_own_version',
    ],
    // Какие контакты связи показать соискателю: email, tel, messenger viber, messenger telegram,
    // Индексы ключи к файлу языка
    'contact_information' => [
        'email',
        'tel',
        'messenger_viber',
        'messenger_telegram',
    ],
    // статус вакансии - стандарт, скрытая, горячая,
    // Индексы ключи к файлу языка
    'job_status' => [
        'standard',
        'hidden',
        'hot',
    ],
    // перечень категорий вакансий
    // Индексы ключи к файлу языка
    'categories' => [
        'it, computers, internet','administration, middle_management','accounting, audit','hotel_and_restaurant_business, tourism','design, creativity',
        'beauty, fitness, sports','culture, music, show_business','logistics, warehouse','marketing, advertising','medicine, pharmaceuticals','real_estate',
        'education, science','security','sales, purchases','working_specialties, production','retail','secretariat, office_work','agriculture, agribusiness',
        'media, publishing, printing','insurance','construction, architecture','service_sector','telecommunications_and_communications','top_management, senior_management',
        'transport, auto_business','personnel_management','finance, bank','jurisprudence','other',
    ],

];
























