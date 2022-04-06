<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{

    protected $guarded = [];
    protected $casts = [
        'country' => 'json',
        'region' => 'json',
        'city' => 'json',
        'type_employment' => 'json',
        'salary' => 'json',
        'vacancy_suitable' => 'json',
    ];
}
