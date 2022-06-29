<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferChatArchive extends Model{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected $casts = [
        'chat' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'alias';
    }
}
