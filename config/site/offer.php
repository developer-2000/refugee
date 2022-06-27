<?php

return [

    /**
     * 'title_chat' - содержит название нашего чата.
     * Меняется в момент предложения своего документа, на название документа.
     * Заполняеться только в 0 елементе масива сообщений.
     */
    'message' => [
        'user_id'=>null,            // кто выслал message
        'date_create'=>null,        // время создания сообщения
        'my_type_document'=>null,   // тип предложенного моего документа для заголовка - resume / vacancy
        'your_type_document'=>null, // тип предложенного собеседника документа для заголовка - resume / vacancy
        'my_offer_title'=>null,     // position моего документа
        'your_offer_title'=>null,   // position документа собеседника
        'my_offer_url'=>null,       // url моего документа
        'your_offer_url'=>null,     // url документа собеседника
        'covering_letter'=>null,    // сопроводительный текст сообщения
        'your_viewing'=>0,          // просмотр сообщения собеседником (для редактирования)
        'important_message'=>0,     // сообщения типа not_interested, need_solved
    ],

];
























