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

class GoogleController extends Controller {

    CONST DRIVER_TYPE = 'google';

    public function redirect() {

        return Socialite::driver("google")->redirect();
    }

    public function callback() {
        try {
            $user = Socialite::driver(static::DRIVER_TYPE)->user();
            $userExisted = User::where('oauth_id', $user->id)->where('oauth_type', static::DRIVER_TYPE)->first();

            if(is_null($userExisted)) {
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
            }

            Auth::login($userExisted);
            return redirect()->route('index');
        }
        catch (Exception $e) {
            return Redirect::route('index')->withErrors(['errors'=>'Verification google error']);
        }
    }
}
