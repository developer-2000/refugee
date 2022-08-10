<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\BreadcrumbsTraite;
use App\Model\User;
use App\Model\UserContact;
use App\Repositories\VacancyRepository;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;

class AuthBaseController extends Controller {

    protected function getSocialiteDriver(){
        return Socialite::driver(static::DRIVER_TYPE)->user();
    }

    protected function createSocialiteUser($user){
        $userExisted = User::create([
            'email' => $user->email,
            'password' => Hash::make($user->id),
            'oauth_id' => $user->id,
            'oauth_type' => static::DRIVER_TYPE,
            'email_verified_at'=>now(),
        ]);

        UserContact::create([
            'user_id'=>$userExisted->id,
            'name'=>$user->name,
            'surname'=>$user->name,
        ]);

        return $userExisted;
    }

}
