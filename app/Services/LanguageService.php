<?php
namespace App\Services;

use App\Model\Test;
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
        $url = url()->current();
        $url = explode("/", $url);
        $url = array_filter($url, function($value) { return $value !== ''; });
        $url = array_values( $url );
        if(isset($url[0])){
            $prefix_lang = in_array($url[0], config("app.all_lang")) ?
                "/$url[0]" :
                '/';
        }

        return $prefix_lang;
    }

    /**
     * очистка префикса языка для url
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|string
     */
    public function clearPrefixLanguage()
    {
        $lang = session('prefix_lang');
        if ($lang === "/uk/") {
            $lang = "/uk";
        } elseif ($lang === "/ru/") {
            $lang = "/ru";
        }

        return $lang;
    }

    // выбрать из url язык сайта
    public function selectLangFromUrl() {
        $prefix_lang = null;
        $url = url()->current();
        $url = explode("/", $url);
        $url = array_filter($url, function($value) { return $value !== ''; });
        $url = array_values( $url );
        $languages = config("app.all_lang");

        // зачистить от ненужных символов
        foreach ($url as $index => $value) {
            $url[$index] = preg_replace('/[^a-z]/ui', '', $value);
        }

        foreach ($languages as $key => $value) {
            if( array_search($value, $url) !== false ){
                $prefix_lang = $value;
                break;
            }
        }

        return is_null($prefix_lang) ? "en" : $prefix_lang;
    }

}
