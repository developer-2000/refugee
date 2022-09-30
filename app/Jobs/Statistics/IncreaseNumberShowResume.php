<?php

namespace App\Jobs\Statistics;

use App\Services\StatisticResumesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncreaseNumberShowResume implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $arr_id_resumes=[];
    public $tries=3;

    /**
     * lotokvest@gmail.com
     * @param $arr
     */
    public function __construct($arr) {
        $this->arr_id_resumes= $arr['arr_id_resumes'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $statisticService = new StatisticResumesService();
        $statisticService->increaseNumberShow($this->arr_id_resumes);
    }

}
