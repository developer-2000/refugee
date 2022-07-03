<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GeographyDb extends Model
{

    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'country' => 'json',
        'regions' => 'json',
        'cities' => 'json',
    ];
}
