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

}
