<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'country' => 'json',
        'region' => 'json',
        'city' => 'json',
    ];
}
