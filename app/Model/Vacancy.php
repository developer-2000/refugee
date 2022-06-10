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

    // название должности
    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
            $data->url = '/img/company/company-default.jpg';
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
                "url" => "img/company/company-default.jpg",
            ];
        });
    }

    public function id_saved_vacancies() {
        $user_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        return $this->hasMany(UserSaveVacancy::class, 'vacancy_id', 'id')
            ->where('user_id',$user_id);
    }

    public function id_not_shown_vacancies() {
        $user_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        return $this->hasMany(UserHideVacancy::class, 'vacancy_id', 'id')
            ->where('user_id',$user_id);
    }

}
