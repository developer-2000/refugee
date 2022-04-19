<?php
namespace App\Services;

use Illuminate\Support\Facades\App;

class LocalizationService
{
    // динамический префикс языка и назначение translation сайта
    public function locale()
    {
        // префикс альтернативного языка присутствует
        $locale = request()->segment(1, '');
        if($locale && in_array($locale, config("app.alternative_lang"))){
            App::setLocale($locale);
            return $locale;
        }
        // язык указан по умолчанию - назначить язык по умолчанию
        elseif( $locale && $locale == config("app.locale") ) {
            App::setLocale(config("app.locale"));

            // редирект без префикса
            $segments = request()->segments();
            $segments[0] = '';
            $string = implode("/", $segments);
            return redirect($string)->send();
        }

        // все что не папало в условие App::getLocale() отдает по умолчанию (en)

        return "";
    }

}
