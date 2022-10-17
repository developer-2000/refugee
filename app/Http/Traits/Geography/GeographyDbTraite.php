<?php
namespace App\Http\Traits\Geography;

use App\Exceptions\UserException;
use App\Model\GeographyTranslate;
use MenaraSolutions\Geographer\Country;

trait GeographyDbTraite {

    // 0 => страна [ "code" => "AF", "name" => "Afghanistan" ]
    // создает custom array стран
    protected function customArrCountry($all_county) {
        $arrCountry = [];

        foreach ($all_county as $key => $arr) {
            // найти эту страну в настройках нужных стран приложения
            if (array_search($arr['code'], $this->settingsCountry) !== false){
                array_push($arrCountry, [
                    'code' => mb_strtoupper($arr['code']),
                    'name' => $arr['name'],
                ]);
            }
        }

    return $arrCountry;
    }

    // создать custom масив штатов
    // штаты [▼
    //    0 => штат [▼
    //       "code" => 1121143
    //       "name" => "Zabul"
    protected function customArrStatesCountry($arrCount, $lang){

        $customStates = [];
        // Регионы страны - указано страна и язык
        $allStates = Country::build($arrCount["code"])
            -> setLocale(mb_strtoupper($lang)) -> getStates() -> toArray();

        // перебор регионов страны
        foreach ($allStates as $key3 => $arrState){
            array_push($customStates, [
                'code' => $arrState['code'],
                'name' => $arrState['name'],
            ]);
        }

    return $customStates;
    }

    // регионы и города в них
    protected function customArrCitiesRegions($codeCountry, $lang){
        $arrayRegions = [];
        // страна по code и языку
        $county = Country::build($codeCountry)->setLocale($lang);

        // перебрать регионы
        foreach ($county->getStates() as $region) {
            // масив городов региона
            $arrayCities = $this->foreachCities($region);

            try {
                if (count($arrayCities)){
                    $arrayRegions[ $region->toArray()['code'] ] = $arrayCities;
                }
            } catch (\Exception $e) {
                logger('Произошла ошибка - ' . $e->getMessage() . ' --- Файл - ' . $e->getFile() . ' --- Строка - ' . $e->getLine());
            }
        }

    return $arrayRegions;
    }

    // масив городов региона
    private function foreachCities($region){
        $arrayCities = [];
            // перебрать города
            foreach ($region->getCities() as $city) {
                $city = $city->toArray();
                if (isset($city['code']) && is_int($city['code']) && isset($city['name']) && is_string($city['name'])) {
                    $arrayCities[] = $city;
                }
            }

    return $arrayCities;
    }

    /**
     * записать в базу переводы локаций
     * ru переводы - страны, регионы (города в en)
     * en переводы - страны, регионы, города
     */
    private function enterTranslationIntoDatabase(){
        $url_country = config('site.locale.url_country');
        $url_region = config('site.locale.url_region');
        $url_city = config('site.locale.url_city', 'city');
        $arrCountries = $this->collectCountryFileData($url_country);
        $arrRegions = $this->collectCountryFileData($url_region);
        $arrCities = $this->collectCountryFileData($url_city, 'city');

        GeographyTranslate::updateOrCreate(
            ['id' => '1'],
            [
                'country'=>$arrCountries,
                'regions'=>$arrRegions,
                'cities'=>$arrCities,
            ]
        );
    }

    /**
     * логика формирования переводов в базе
     * @param $url_country
     * @param  null  $location
     * @return array|mixed
     */
    private function collectCountryFileData($url_country, $location = null) {
        // языки перевода ru, ua ...
        $arrLanguages = array_keys(config('site.locale.languages'));
        $original_url = public_path().$url_country["original"];
        $url_translate = public_path().$url_country["translate"];
        $arrOriginal = [];

        // перебераю все языки перевода
        foreach ($arrLanguages as $index => $prefix_lang) {

            if($prefix_lang === 'en'){
                $arrOriginal = $this->fetchFromFileCountry($original_url, $prefix_lang, $arrOriginal);
            }
            elseif($prefix_lang === 'ru'){
                // в случае с городами - изначальный перевод en
                if($location === 'city'){
                    $arrOriginal['RU'] = $arrOriginal['EN'];
                    $arrOriginal = $this->fetchFromFileCountry($url_translate.'ru/', $prefix_lang, $arrOriginal);
                }
                else{
                    $arrOriginal = $this->fetchFromFileCountry($url_translate.'ru/', $prefix_lang, $arrOriginal);
                }
            }
            elseif($prefix_lang === 'uk'){
                $arrOriginal['UK'] = $arrOriginal['RU'];
                $arrOriginal = $this->fetchFromFileCountry($url_translate.'uk/', $prefix_lang, $arrOriginal);
            }
            elseif($prefix_lang === 'ro'){
                $arrOriginal['RO'] = $arrOriginal['EN'];
                $arrOriginal = $this->fetchFromFileCountry($url_translate.'ro/', $prefix_lang, $arrOriginal);
            }
        }

        return $arrOriginal;
    }

    /**
     * выборка файлов и формирование обьекта для базы
     * @param $url_dir
     * @param $prefix_lang
     * @param $arrOriginal
     * @return mixed
     */
    private function fetchFromFileCountry($url_dir, $prefix_lang, $arrOriginal) {
        $upLang = mb_strtoupper($prefix_lang);

            // ../files/country/translate/ru
            if($this->checkingPathExists($url_dir)){
                $files = scandir($url_dir);
                foreach ($files as $key => $name){
                    if (strripos($name, ".php") !== false) {
                        // содержимое файла
                        $file = include $url_dir.$name;
                        $prefix_country = substr($name, 0, strpos($name, "."));
                        if (!isset($arrOriginal[$upLang][$prefix_country])) {
                            $arrOriginal[$upLang][$prefix_country] = [];
                        }

                        foreach ($file as $property => $value){
                            $arrOriginal[$upLang][$prefix_country][$property] = $value;
                        }
                    }
                }
            }

        return $arrOriginal;
    }

    // проверка существования пути
    private function checkingPathExists($path){
        if (!is_dir($path)) {
            return false;
        }
        return true;
    }

}
