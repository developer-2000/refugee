<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserResume extends Model
{
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'languages' => 'array',
        'contacts' => 'array',
        'vacancy_suitable' => 'json',
        'salary' => 'json',
        'country' => 'json',
        'region' => 'json',
        'city' => 'json',
        'job_posting' => 'json',
    ];

    public function getRouteKeyName()
    {
        return 'alias';
    }

    // название резюме
    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    // владелец резюме
    public function contact() {
        return $this->belongsTo(UserContact::class, 'user_id', 'user_id');
    }

    // смежная таблица для подписок
    public function respond() {
        return $this->hasMany(RespondResume::class, 'resume_id', 'id');
    }

    public function id_saved_resumes() {
        $user_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        return $this->hasMany(UserSaveResume::class, 'resume_id', 'id')
            ->where('user_id',$user_id);
    }

    public function id_hide_resumes() {
        $user_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        return $this->hasMany(UserHideResume::class, 'resume_id', 'id')
            ->where('user_id',$user_id);
    }
}
