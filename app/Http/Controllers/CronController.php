<?php
namespace App\Http\Controllers;

use App\Model\Resume;
use App\Model\Vacancy;
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

    /**
     *  псевдо проверка админом и показ документа
     *  Cron через 10 мин активировать созданные документы, которые
     *  не опубликована
     *  админ не проверял
     *  юзер активировал,
     */
    public function pseudoCheckByAdminAndShowDocument() {

        $config = config("site.settings_vacancy");

        // не заблокирована админом и активирована юзером
        $vacancies = Vacancy::where("published", 0)
            ->where("check_admin", 0)
            ->whereJsonContains('job_posting->status_name', $config['job_status'][0])
            ->get();

        foreach ($vacancies as $key => $vacancy){
            $vacancy->published = 1;
            $vacancy->save();
        }

        // не заблокирована админом и активирована юзером
        $resumes = Resume::where("published", 0)
            ->where("check_admin", 0)
            ->whereJsonContains('job_posting->status_name', $config['job_status'][0])
            ->get();

        foreach ($resumes as $key => $resume){
            $resume->published = 1;
            $resume->save();
        }
    }


}
