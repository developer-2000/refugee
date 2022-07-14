<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $guarded = [];
    protected $casts = [
        'categories' => 'array',
        'youtube_links' => 'array',
    ];

    /**
     * default image в том случае если компания создана а картинка не загружена
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image() {
        return $this->belongsTo(Image::class, 'logo_id', 'id')
            ->withDefault(function ($image) {
            $image->url = 'img/company/default/company-default.jpg';
        });
    }

    public function vacancies() {
        return $this->hasMany(Vacancy::class, 'user_id', 'user_id');
    }

    public function contact() {
        return $this->hasOne(UserContact::class, 'user_id', 'user_id');
    }

    public function country() {
        return $this->hasOne(GeographyLocal::class, 'id', 'country_id');
    }

    public function region() {
        return $this->hasOne(GeographyLocal::class, 'id', 'region_id');
    }

    public function city() {
        return $this->hasOne(GeographyLocal::class, 'id', 'city_id');
    }
}
