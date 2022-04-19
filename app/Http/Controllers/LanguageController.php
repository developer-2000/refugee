<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{

    /**
     * изменение префикса языка в url
     * @param $name
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeLanguage($name) {
        $last_page = URL::previous();
        $arrPath = explode("/", $last_page);

        // переданый язык являетса дополнительным языком сайта
        if( in_array($name, config("app.alternative_lang")) ){
            // префикс из URL есть в дополнительных языках - замена префикса
            // http://refugee/ru/vacancy/my-vacancies
            if(isset($arrPath[3]) && in_array($arrPath[3], config("app.alternative_lang"))){
                $arrPath[3] = $name;
            }
            // префикс из URL не являетса языком - добавить к префиксу
            // request - http://refugee/uk/vacancy/my-vacancies
            elseif(isset($arrPath[3]) && !in_array($arrPath[3], config("app.all_lang"))){
                $arrPath[3] = "$name/".$arrPath[3];
            }
            // префикс не существует (в случае отсутствия / в конце) -
            elseif( !isset($arrPath[3]) ){
                $arrPath[2] = $arrPath[2]."/$name";
            }
        }
        // переданый язык основной язык сайта
        elseif( in_array($name, config("app.all_lang")) ){
            // префикс из URL есть в языках сайта - замена префикса
            if(isset($arrPath[3]) && in_array($arrPath[3], config("app.all_lang"))){
                unset($arrPath[3]);
            }
        }

        $last_page = implode("/", $arrPath);

        return redirect($last_page)->send();
    }
}
