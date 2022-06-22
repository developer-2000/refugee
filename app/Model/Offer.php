<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    protected $guarded = [];
    protected $casts = [
        'chat' => 'array',
    ];


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
