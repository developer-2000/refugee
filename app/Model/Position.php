<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    protected $guarded = [];
    public $timestamps = false;

    public function getTitleAttribute($value)
    {
        return ucfirst($value);
    }

}
