<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LocalizationFacades extends Facade
{
    // обратиться к ячейке provider
    public static function getFacadeAccessor()
    {
        return "Localization";
    }

}
