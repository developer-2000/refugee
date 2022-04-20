<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $guarded = [];

    public function logo() {
        return $this->belongsTo(Image::class, 'logo_id', 'id');
    }
}
