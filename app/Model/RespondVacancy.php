<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RespondVacancy extends Model
{
    protected $guarded = [];

    // выбрать респонд по vacancy_id и user_resume_id
    public function selectByVacancyUserResumeId($vacancy_id, $user_id) {
        return $this->where('vacancy_id',$vacancy_id)
            ->where('user_resume_id',$user_id)->first();
    }

    // выбрать респонд по resume_id и user_vacancy_id
    public function selectByResumeUserVacancyId($resume_id, $user_id) {
        return $this->where('resume_id',$resume_id)
            ->where('user_vacancy_id',$user_id)->first();
    }
}
