<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = [];
    protected $casts = [
        'text' => 'json',
    ];
}
