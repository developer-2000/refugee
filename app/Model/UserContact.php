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

    // аватар юзера
    public function avatar() {
        return $this->belongsTo(Image::class, 'avatar_id', 'id');
    }

    // назначить url avatar default
    protected static function boot() {
        parent::boot();
        static::created(function (UserContact $model) {
            $default_avatar_url = "img/avatars/default/man.jpg";
            $model->default_avatar_url = $default_avatar_url;
            $model->save();
        });
    }
}
