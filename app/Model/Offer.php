<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];
    protected $casts = [
        'chat' => 'array',
    ];
}
