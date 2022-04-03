<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MakeGeographyDb extends Model
{

    protected $table = 'make_geography_dbs';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'country' => 'json',
        'regions' => 'json',
        'cities' => 'json',
    ];
}
