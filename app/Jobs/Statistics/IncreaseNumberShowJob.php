<?php

namespace App\Jobs\Statistics;

use App\Services\StatisticVacanciesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncreaseNumberShowJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $arr_id_vacancies=[];
    public $tries=3;

    /**
     * lotokvest@gmail.com
     * @param $arr
     */
    public function __construct($arr) {
        $this->arr_id_vacancies= $arr['arr_id_vacancies'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $statisticService = new StatisticVacanciesService();
        $statisticService->increaseNumberShow($this->arr_id_vacancies);
    }

}
