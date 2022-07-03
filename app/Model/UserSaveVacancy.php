<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSaveVacancy extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function vacancy() {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'id');
    }

}
