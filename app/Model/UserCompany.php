<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'youtube_links' => 'array',
        'country' => 'json',
        'region' => 'json',
        'city' => 'json',
    ];

    public function image() {
        return $this->belongsTo(Image::class, 'logo_id', 'id');
    }
}
