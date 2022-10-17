<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendActivateAccount;
use App\Model\Permission;
use App\Model\User;
use App\Model\UserContact;
use App\Model\UserPermission;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthBaseController extends Controller {

    protected function getSocialiteDriver(){
        return Socialite::driver(static::DRIVER_TYPE)->user();
    }

    protected function createSocialiteUser($driver){
        $user = User::create([
            'email' => $driver->email,
            'password' => Hash::make($driver->id),
            'oauth_id' => $driver->id,
            'oauth_type' => static::DRIVER_TYPE,
            'email_verified_at'=>now(),
        ]);

        $permission = Permission::where("name", "user")->first();
        UserPermission::create([
            "user_id"=>$user->id,
            "permission_id"=>$permission->id,
        ]);

        UserContact::create([
            'user_id'=>$user->id,
            'name'=>$driver->name,
            'surname'=>$driver->name,
        ]);

        SendActivateAccount::dispatch($driver->email)
            ->onQueue('emails');

        return $user;
    }

}
