<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LinkedinController extends AuthBaseController {

    CONST DRIVER_TYPE = 'linkedin';

    public function redirect() {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function callback() {
        try {
            $driver = $this->getSocialiteDriver();
            $user = User::where('email', $driver->email)->first();

            // 1 новый пользователь
            if(is_null($user)) {
                $user = $this->createSocialiteUser($driver);
            }

            Auth::login($user);
            return redirect()->route('index');
        }
        catch (Exception $e) {
            return Redirect::route('index')->withErrors(['errors'=>'Verification '.static::DRIVER_TYPE.' error']);
        }
    }
}
