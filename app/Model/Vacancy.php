<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{

    protected $guarded = [];
    protected $casts = [
        'categories' => 'json',
        'vacancy_suitable' => 'json',
        'salary' => 'json',
        'search_city' => 'json',
    ];
}
