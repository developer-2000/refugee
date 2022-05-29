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
    ],

    /*
     * The default path to use for the generated javascript.
     */
    'path' => resource_path('js/vue-translations.js'),
];
