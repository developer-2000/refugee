<?php

namespace App\Http\Controllers;

use App\Http\Requests\Respond\RespondResumeRequest;
use App\Http\Requests\Respond\RespondVacancyRequest;
use App\Model\RespondResume;
use App\Repositories\RespondResumeRepository;
use App\Repositories\RespondVacancyRepository;


class RespondController extends BaseController {

    protected $repositoryVacancy;
    protected $repositoryResume;

    public function __construct() {
        $this->repositoryVacancy = new RespondVacancyRepository();
        $this->repositoryResume = new RespondResumeRepository();
    }

    /**
     * откликнуться на вакансию
     * @param  RespondVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondVacancy(RespondVacancyRequest $request) {
        $respond = $this->repositoryVacancy->respondVacancy($request);
        return $this->getResponse($respond);
    }

    /**
     * откликнуться на резюме
     * @param  RespondVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondResume(RespondResumeRequest $request) {
        $respond = $this->repositoryResume->respondResume($request);
        return $this->getResponse();
    }
}
