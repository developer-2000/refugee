<?php

return [

    /*
     * Set the names of files you want to add to generated javascript.
     * Otherwise all the files will be included.
     *
     * 'messages' => [
     *     'validation',
     *     'forum/thread',
     * ],
     *
     * php artisan lang:js --quiet --no-lib
     */
    'messages' => [
        'menu/menu',
        'auth',
        'vacancies',
        'company',
        'office',
        'contact',
        'respond',
        'cookie',
        'pages/index',
        'pages/charity',
        'pages/feedback',
        'pages/offer',
        'pages/customer_survey',
        'details/date_mixin',
        'details/back_url',
        'details/sharing_panel',
        'details/contacts',
    ],

    /*
     * The default path to use for the generated javascript.
     */
    'path' => resource_path('js/vue-translations.js'),
];
