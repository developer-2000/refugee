<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
}
