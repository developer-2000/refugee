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

    /**
     * увеличить количество показов
     * @param $idResumes
     */
    public function increaseNumberShow($idResumes) {
        foreach ($idResumes as $key => $id){
            $collection = $this->model->firstOrCreate([
                'resume_id' => $id
            ]);
            $collection->increment('show');
            $collection->save();
        }
    }

    public function increaseNumberUpdate($resume_id) {
        $collection = $this->model->firstOrCreate([
            'resume_id' => $resume_id
        ]);
        $collection->increment('update');
        $collection->save();
    }

    public function increaseNumberView($resume_id) {
        $collection = $this->model->firstOrCreate([
            'resume_id' => $resume_id
        ]);
        $collection->increment('view');
        $collection->save();
    }

}
