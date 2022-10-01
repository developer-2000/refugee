<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CronController {

    /**
     * запуск выполнения default job задач
     */
    public function runJobDefault() {

        Artisan::call('queue:work --queue=default --stop-when-empty', []);
    }

    /**
     * запуск выполнения emails job задач
     */
    public function runJobEmails() {

        Artisan::call('queue:work --queue=emails --stop-when-empty', []);
    }

}
