<?php
namespace App\Http\Controllers;

use App\Model\Resume;
use App\Model\Vacancy;
use App\Services\InstrumentService;
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
     *  псевдо проверка админом и активация документа
     *  Cron через 10 мин активировать созданные документы, которые
     *  не опубликована
     *  админ не проверял
     *  юзер активировал,
     * @throws \Exception
     */
    public function pseudoCheckByAdminAndShowDocument() {
        $config = config("site.settings_vacancy");
        $arrModels = [new Vacancy(), new Resume()];
        $service = new InstrumentService();

        foreach ($arrModels as $key => $model){
            // не заблокирована админом и активирована юзером
            $collections = $model->where("published", 0)
                ->where("check_admin", 0)
                ->whereJsonContains('job_posting->status_name', $config['job_status'][0])
                ->get();

            $this->activationCycle($collections, $config, $service);
        }
    }

    /**
     * Деактивировать устаревшие документы
     */
    public function deactivateOldDocuments() {
        $config = config("site.settings_vacancy");
        $arrModels = [new Vacancy(), new Resume()];
        $service = new InstrumentService();

        foreach ($arrModels as $key => $model){
            // не заблокирована админом и активирована юзером
            $collections = $model->where("published", 1)
                ->whereJsonContains('job_posting->status_name', $config['job_status'][0])
                ->get();

            // 1 заменить статус активности документа
            $this->deactivationCycle($collections, $config, $service);
        }
    }


    /**
     * переборка активации
     * @param $collections
     * @param $config
     * @param $service
     */
    private function activationCycle($collections, $config, $service) {

        foreach ($collections as $key => $coll){
            $limit = 0;

            // 1 вернет разницу в днях между старой датой и сейчас (добавлен жизненный цикл standard 30дней)
            try {
                $limit = $service->returnDifferenceDateDays(
                        $coll->job_posting['create_time'],
                        $add_time = $config["lifetime_days_job_status"]["standard"],
                        $type_add_time = 3
                    );
            } catch (\Exception $e) {}
            // 2 standard имеет время жизни
            if($limit > 0){
                $coll->published = 1;
                $coll->save();
            }
        }
    }

    /**
     * переборка деактивации
     * @param $collections
     * @param $config
     * @param $service
     */
    private function deactivationCycle($collections, $config, $service) {

        foreach ($collections as $key => $coll){
            $limit = 0;

            // 1 вернет разницу в днях между старой датой и сейчас (добавлен жизненный цикл standard 30дней)
            try {
                $limit = $service->returnDifferenceDateDays(
                        $coll->job_posting['create_time'],
                        $add_time = $config["lifetime_days_job_status"]["standard"],
                        $type_add_time = 3
                    );
            } catch (\Exception $e) {}

            // 2 standard прекратил свой цикл
            if($limit <= 0){
                $coll->published = 0;
                $coll->job_posting = [
                    'status_name'=> $config['job_status'][1],
                    'create_time'=>now()->subDays($config["lifetime_days_job_status"]["standard"]),
                ];
                $coll->save();
            }
        }
    }

}
