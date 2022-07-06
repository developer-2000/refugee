<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function permission() {
        return $this->belongsToMany(
            Permission::class,     // конечная модель
            UserPermission::class,  // промежуточная модель
            'user_id',
            'permission_id'
        );
    }

}
