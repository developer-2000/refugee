<?php
namespace App\Services;

use Illuminate\Support\Facades\App;

class LanguageService
{
    /**
     * выбрать флаги и языки для менюхи
     * @return array
     */
    public function getLanguageArray() {
        $lang = [];
        $array_land = config('site.locale.languages');   // мой масив языков
        $lang_local = App::getLocale();
        $avatar = $array_land[$lang_local][3]['avatar'];
        // для front "`${lang.prefix_lang} more url `"
        $prefix_lang = in_array($lang_local, config("app.alternative_lang")) ?
            "/$lang_local/" :
            '/';
        // для back-end - redirect(session('prefix_lang'));
        session(['prefix_lang' => $prefix_lang]);

        // создать масив языков для клиентской части
        foreach ($array_land as $array){
            $lang[] = (object) $array[3];
        }

        return compact( 'avatar', 'lang', 'lang_local', 'prefix_lang');
    }

    /**
     * создать префикс языка системы из url
     * @return string
     */
    public function createSystemLanguageFromUrl() {
        $prefix_lang = '/';
//        if (isset($_SERVER['REQUEST_URI'])){
//            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $url = url()->current();
            $url = explode("/", $url);
            $url = array_filter($url, function($value) { return $value !== ''; });
            $url = array_values( $url );
            if(isset($url[0])){
                $prefix_lang = in_array($url[0], config("app.all_lang")) ?
                    "/$url[0]" :
                    '/';
            }
//        }

        return $prefix_lang;
    }

}
