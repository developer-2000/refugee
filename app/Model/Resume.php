<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Resume extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'languages' => 'array',
        'salary' => 'json',
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

    public function country() {
        return $this->belongsTo(GeographyLocal::class, 'country_id', 'id');
    }

    public function region() {
        return $this->belongsTo(GeographyLocal::class, 'region_id', 'id');
    }

    public function city() {
        return $this->belongsTo(GeographyLocal::class, 'city_id', 'id');
    }

    // смежная таблица для подписок
    public function respond() {
        return $this->hasMany(RespondResume::class, 'resume_id', 'id');
    }

    public function statistic() {
        return $this->hasOne(StatisticResume::class, 'resume_id', 'id')
            ->withDefault(function ($user, $post) {
                $user->respond = 0;
                $user->show = 0;
                $user->update = 0;
                $user->view = 0;
            });
    }

}
