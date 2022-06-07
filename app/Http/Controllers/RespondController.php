<?php

namespace App\Http\Controllers;

use App\Http\Requests\Respond\RespondVacancyRequest;
use App\Repositories\RespondVacancyRepository;


class RespondController extends BaseController {

    protected $repository;

    public function __construct() {
        $this->repository = new RespondVacancyRepository();
    }

    /**
     * откликнуться на вакансию
     * @param  RespondVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondVacancy(RespondVacancyRequest $request) {
        $respond = $this->repository->respondVacancy($request);

        return $this->getResponse();
    }

}
