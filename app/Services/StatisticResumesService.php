<?php
namespace App\Services;

use App\Model\StatisticResume;

class StatisticResumesService {

    protected $model;

    public function __construct() {
        $this->model = new StatisticResume();
    }

    public function increaseNumberRespond($resume_id) {
        $collection = $this->model->firstOrCreate([
            'resume_id' => $resume_id
        ]);
        $collection->increment('respond');
        $collection->save();
    }

}
