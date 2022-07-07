<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeographyTranslate extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'country' => 'json',
        'regions' => 'json',
        'cities' => 'json',
    ];
}
