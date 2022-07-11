<?php
namespace App\Http\Traits\Admin;

use Illuminate\Support\Carbon;

trait AdminTrait
{

    /**
     * проверка указанного доступа у юзера
     * @param $access
     * @return bool
     */
    public function checkAccess($access) {
        if($user = auth()->user()){
            $permissionsArr = $user->permission->pluck('name');
            if (count($permissionsArr) && in_array($access, $permissionsArr->toArray())){
                return true;
            }
        }

        return false;
    }

}
