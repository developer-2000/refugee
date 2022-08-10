<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends AuthBaseController {

    CONST DRIVER_TYPE = 'google';

    public function redirect() {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function callback() {
        try {
            $user = $this->getSocialiteDriver();
            $userExisted = User::where('email', $user->email)->first();

            if(is_null($userExisted)) {
                $userExisted = $this->createSocialiteUser($user);
            }

            Auth::login($userExisted);
            return redirect()->route('index');
        }
        catch (Exception $e) {
            return Redirect::route('index')->withErrors(['errors'=>'Verification google error']);
        }
    }
}
