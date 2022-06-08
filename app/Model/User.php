<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
//'first_name', 'last_name',
    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vacancies() {
        return $this->hasMany(Vacancy::class, 'user_id', 'id');
    }

    public function company() {
        return $this->hasOne(UserCompany::class, 'user_id', 'id');
    }

    public function contact() {
        return $this->hasOne(UserContact::class, 'user_id', 'id');
    }
}
