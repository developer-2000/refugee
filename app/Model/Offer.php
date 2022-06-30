<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    public $inTable = [
        'offer'=>true,
        'archive'=>null,
    ];
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

    // чат двух юзеров по id
    public function selectChatByUserId($user_id, $my_id) {
        // 1 offer в своей таблице
        $offer = $this->where(function($query) use ($my_id, $user_id) {
            $query->where(function ($query) use ($my_id, $user_id) {
                $query->where('one_user_id', $my_id)
                    ->where('two_user_id', $user_id);
            })
                ->orWhere(function ($query) use ($my_id, $user_id) {
                    $query->where('one_user_id', $user_id)
                        ->where('two_user_id', $my_id);
                });
        })->first();
        // 2 offer в архиве
        if(is_null($offer)){
            $this->inTable = [
                'offer'=>null,
                'archive'=>true,
            ];

            $offer = OfferChatArchive::where(function($query) use ($my_id, $user_id) {
                $query->where(function ($query) use ($my_id, $user_id) {
                    $query->where('one_user_id', $my_id)
                        ->where('two_user_id', $user_id);
                })
                    ->orWhere(function ($query) use ($my_id, $user_id) {
                        $query->where('one_user_id', $user_id)
                            ->where('two_user_id', $my_id);
                    });
            })->first();
        }

        return $offer;
    }



}
