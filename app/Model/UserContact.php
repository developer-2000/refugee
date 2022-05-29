<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $guarded = [];
    protected $casts = [
        'messengers' => 'array',
    ];

    // название должности
    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

}
