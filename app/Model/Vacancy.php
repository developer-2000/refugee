<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Vacancy extends Model
{
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'languages' => 'array',
        'vacancy_suitable' => 'json',
        'salary' => 'json',
        'job_posting' => 'json',
    ];

    public function getRouteKeyName()
    {
        return 'alias';
    }

    // название должности
    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // владелец вакансии
    public function contact() {
        return $this->belongsTo(UserContact::class, 'user_id', 'user_id');
    }

    // Image чарез company
    // цепочка = Vacancy user_id, company user_id, company logo_id,
    public function logo_company() {
        return $this->hasOneThrough(
            Image::class,      // доступ
            UserCompany::class,  // промежуточная
            'user_id',         // мой локальный
            'id',           // доступ
            'user_id',        // внешний промежуточная
            'logo_id'   // внешний промежуточная
        )->withDefault(function ($data) {
            $data->title = 'Default logo';
            $data->url = '/img/company/default/company-default.jpg';
        });
    }

    // company через User
    // цепочка = Vacancy user_id, User id, company user_id,
    public function company() {
        return $this->hasOneThrough(
            UserCompany::class,
            User::class,
            'id',
            'user_id',
            'user_id',
            'id'
        )->withDefault(function ($data) {
            $data->title = 'Default company title';
            $data->image = [
                "title" => "Default logo",
                "url" => "img/company/default/company-default.jpg",
            ];
        });
    }

    public function id_saved_vacancies() {
        $user_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        return $this->hasMany(UserSaveVacancy::class, 'vacancy_id', 'id')
            ->where('user_id',$user_id);
    }

    public function id_hide_vacancies() {
        $user_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        return $this->hasMany(UserHideVacancy::class, 'vacancy_id', 'id')
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
        return $this->hasMany(RespondVacancy::class, 'vacancy_id', 'id');
    }

    public function statistic() {
        return $this->hasOne(StatisticVacancy::class, 'vacancy_id', 'id')
            ->withDefault(function ($user, $post) {
            $user->respond = 0;
            $user->show = 0;
            $user->update = 0;
            $user->view = 0;
        });
    }
}
