<?php
namespace App\Services;

use App\Model\StatisticVacancy;

class StatisticVacanciesService {

    protected $model;

    public function __construct() {
        $this->model = new StatisticVacancy();
    }

    /**
     * увеличить кол-во откликов
     * @param $vacancy_id
     */
    public function increaseNumberRespond($vacancy_id) {
        $collection = $this->model->firstOrCreate([
            'vacancy_id' => $vacancy_id
        ]);
        $collection->increment('respond');
        $collection->save();
    }

    /**
     * увеличить количество показов
     * @param $idVacancies
     */
    public function increaseNumberShow($idVacancies) {
        foreach ($idVacancies as $key => $id){
            $collection = $this->model->firstOrCreate([
                'vacancy_id' => $id
            ]);
            $collection->increment('show');
            $collection->save();
        }
    }

    public function increaseNumberUpdate($vacancy_id) {
            $collection = $this->model->firstOrCreate([
                'vacancy_id' => $vacancy_id
            ]);
            $collection->increment('update');
            $collection->save();
    }

    public function increaseNumberView($vacancy_id) {
            $collection = $this->model->firstOrCreate([
                'vacancy_id' => $vacancy_id
            ]);
            $collection->increment('view');
            $collection->save();
    }

}
