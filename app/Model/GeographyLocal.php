<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeographyLocal extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'local' => 'json',
    ];
}
