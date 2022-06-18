<?php

return [
    // Какие контакты связи подключены к указанному номеру телефона
    'contact_information' => [
        'Telegram',
        'Viber',
        'WhatsApp',
    ],
    // auth - авторизованность человека, просматривающий документ
    // received_respond - факт принятия отклика на документ (я откликнулся , он ответил)
    'contact_list' => [
        'avatar_url'=>null,
        'full_name'=>null,
        'position'=>null,
        'email'=>null,
        'skype'=>null,
        'phone'=>null,
        'access'=>[
            'auth'=>null,
            'received_respond'=>null,
        ],
    ],
];
























