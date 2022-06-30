<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferChatArchive extends Model{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'chat' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'alias';
    }

    /**
     * контакты первого юзера чата
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact_one_user() {
        return $this->hasOne(UserContact::class, 'user_id', 'one_user_id');
    }

    /**
     * контакты второго юзера чата
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact_two_user() {
        return $this->hasOne(UserContact::class, 'user_id', 'two_user_id');
    }
}
