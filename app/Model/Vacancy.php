<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'contacts' => 'array',
        'vacancy_suitable' => 'json',
        'salary' => 'json',
        'search_city' => 'json',
        'country' => 'json',
        'region' => 'json',
        'city' => 'json',
        'job_posting' => 'json',
    ];

    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // цепочка = Vacancy user_id, Employer user_id, Employer logo_id,
    public function logo_employer() {
        return $this->hasOneThrough(
            Image::class,      // доступ
            Employer::class,  // промежуточная
            'user_id',         // мой локальный
            'id',           // доступ
            'user_id',        // внешний промежуточная
            'logo_id'   // внешний промежуточная
        )->withDefault(function ($data) {
            $data->title = 'Default logo';
            $data->url = '/img/employer/employer-default.jpg';
        });
    }

}
