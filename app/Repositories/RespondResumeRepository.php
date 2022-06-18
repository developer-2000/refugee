<?php
namespace App\Repositories;

use App\Model\RespondResume as Model;
use App\Model\UserResume;
use App\Model\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RespondResumeRepository extends CoreRepository {

    public function __construct() {
        $this->model = clone app(Model::class);
    }

    /**
     * откликнуться на резюме
     * @param $request
     * @return mixed|null
     */
    public function respondResume($request) {
        $user_resume_id = UserResume::where('id',$request->resume_id)
            ->first()->pluck('user_id');

        return $this->model->create(
            [   'resume_id' => $request->resume_id,
                'vacancy_id' => $request->vacancy_id,
                'user_resume_id' => $user_resume_id[0],
                'user_vacancy_id' => Auth::user()->id,
                'textarea_letter' => $request->textarea_letter
            ]
        );
    }


    /**
     * вернет количество не прочтанных откликов на мои резюме
     * @param  UserResume  $resume
     * @return int
     */
    public function getCountRespondResumes(ResumeRepository $resume) {
        $count = 0;
        if($resumes = $resume->getMyResumes(Auth::user())){
            $arrIdResumes = $resumes->pluck('id');
            $count = $this->model->whereIn('resume_id',$arrIdResumes)
                ->where('review',0)->count();
        }

        return $count;
    }

}
