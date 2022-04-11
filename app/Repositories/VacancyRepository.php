<?php
namespace App\Repositories;

use App\Model\Vacancy as Model;

class VacancyRepository extends CoreRepository {

    public function __construct() {
        $this->model = clone app(Model::class);
    }

    public function storeVacancy($request){
        return $request->all();
    }


}
