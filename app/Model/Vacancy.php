<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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

    // заголовок вакансии
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
            $data->logo = [
                "title" => "Default logo",
                "url" => "/img/company/company-default.jpg",
            ];
        });
    }

    // масив UserSaveVacancy через User
    public function id_saved_vacancies() {
        return $this->hasManyThrough(
            UserSaveVacancy::class,
            User::class,
            'id',
            'user_id',
            'user_id',
            'id'
        );
    }

    // масив UserHideVacancy через User
    public function id_not_shown_vacancies() {
        return $this->hasManyThrough(
            UserHideVacancy::class,
            User::class,
            'id',
            'user_id',
            'user_id',
            'id'
        );
    }

    /**
     * удалить старое название, если оно не будет никем использоватся
     * @param $request
     * @param $position_id
     */
    public static function deleteUnwantedVacancyTitle($request, $position_id) {
        $old_position = Position::where('id', $position_id)->first();
        // название изменено
        if($old_position && $old_position->title !== mb_strtolower($request->position, 'UTF-8')){
            $count_position = Vacancy::where('position_id', $position_id)->count();
            // название использовалось только в этой вакансии
            if($count_position === 1){
                $old_position->delete();
            }
        }
    }

}
