<?php
namespace App\Http\Traits;

use App\Exceptions\UserException;
use App\Model\GeographyTranslate;
use MenaraSolutions\Geographer\Country;

trait GeographyDbTraite {

// ========================================
// ========================================
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

// ========================================
// ========================================
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

// ========================================
// ========================================
    // создать custom масив - code регионы и их города на выбраном языке
    // регионы [▼
    //  code региона => array [
    //    масив городов
    protected function customArrCitiesRegions($codeCountry, $lang){

        $arrayRegions = [];
        // страна по code и языку
        $county = Country::build($codeCountry)->setLocale($lang);

        // перебрать регионы
        foreach ($county->getStates() as $region) {

            // города региона
            $arraySity = $this->foreachCities($region);

            try {
                if (count($arraySity)){
                    $arrayRegions[ $region->toArray()['code'] ] = $arraySity;
                }
            } catch (\Exception $e) {
                logger('Произошла ошибка - ' . $e->getMessage() . ' --- Файл - ' . $e->getFile() . ' --- Строка - ' . $e->getLine());
            }

        }

    return $arrayRegions;
    }

// ========================================
// ========================================
    // перебрать города
    // города [▼
    //    code города => array [
    //      "code" => 1123004
    //      "geonamesCode" => 1123004
    //      "name" => "Taloqan"
    //      "latitude" => 36.73605
    //      "longitude" => 69.53451
    //      "population" => 64256
    private function foreachCities($region){
        $arraySity = [];

            // перебрать города
            foreach ($region->getCities() as $city) {
                $city = $city->toArray();

                if (isset($city['code']) && is_int($city['code']) && isset($city['name']) && is_string($city['name'])) {
                    array_push($arraySity, $city);
                }
            }

    return $arraySity;
    }


    /**
     * создает файлы стран в оригинале перевода
     * @param $array
     */
    private function createFileCountry($array){
        foreach ($array as $key => $arr){
            $line = "<?php \n\n  return [\n ";
            $str = mb_strtolower($arr["name"]);
            $str = str_replace(" ", "_", $str);
            $value = $arr["name"];
            $str = addslashes($str);
            $value = addslashes($value);
            $line .= "'$str'=>'$value',\n ";
            $line .= "];";

            $code = mb_strtolower($arr["code"]);

            file_put_contents(public_path().$this->url_country['original'].$code.".php", $line);
        }
    }

    /**
     * создает файлы регеонов в оригинале перевода
     * @param $array
     * @param  string  $prefix
     */
    private function createFileRegion($array, $prefix=''){
        foreach ($array as $key_name => $arr){
            $line = "<?php \n\n  return [\n ";
            foreach ($arr as $index => $arr2){
                $str = mb_strtolower($arr2["name"]);
                $str = str_replace(" ", "_", $str).$prefix;
                $str = addslashes($str);
                $value = addslashes($arr2["name"]);
                $line .= '"'.$str.'"=>"'.$value.'",'."\n";
            }
            $line .= "];";

            $code = mb_strtolower($key_name);
            file_put_contents(public_path().$this->url_region['original'].$code.".php", $line);
        }
    }

    /**
     * создает файлы городов в оригинале перевода
     * @param $array
     * @param  string  $prefix
     */
    private function createFileCity($array, $prefix=''){
        $arrCities = [];
        // подготовительный масив
        foreach ($array as $code => $arr) {
            $name_country = $this->returnNameCountry($this->arrLangRegion['EN'], $code);
            // создать подмасив страны
            if(!isset($arrCities[$name_country])){
                $arrCities[$name_country] = [];
            }
            $arrCities[$name_country][] = ['name'=>$arr[0]['name']];
        }

        foreach ($arrCities as $key_name => $arr) {
            $line = "<?php \n\n  return [\n ";

            foreach ($arr as $index => $arr2) {
                $str = mb_strtolower($arr2["name"]);
                $str = str_replace(" ", "_", $str).$prefix;
                $str = addslashes($str);
                $value = addslashes($arr2["name"]);
                $line .= '"'.$str.'"=>"'.$value.'",'."\n";
            }

            $line .= "];";

            $code = mb_strtolower($key_name);
            file_put_contents(public_path().$this->url_city['original'].$code.".php", $line);
        }
    }

    /**
     * записать в базу переводы локаций
     * (изначально полностью ru, uk базу заливаю ru, в en базу заливаю оригинал)
     *
     */
    private function enterTranslationIntoDatabase(){
        $arrCountries = $this->makeArrayContent($this->url_country["translate"], $this->url_country["original"]);
        $arrRegions = $this->makeArrayContent($this->url_region["translate"], $this->url_region["original"]);
        $arrCities = $this->makeArrayContent($this->url_city["translate"], $this->url_city["original"]);

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
     * формирует масивы оригинала и перевода файлов
     * @param $url_translate
     * @param $url_original
     * @return array
     */
    private function makeArrayContent($url_translate, $url_original) {
        $url_translate = $url_translate."ru/";
        $arrTranslate = [];
        $languages = config('site.locale.languages');

        // перебераю все языки перевода
        foreach ($languages as $name_lang => $array) {
            // 1 создается префикс перевода
            $arrTranslate[mb_strtoupper($name_lang)] = [];

            // готовый перевод ru залить в ru и uk
            if ($name_lang === 'ru' || $name_lang === 'uk') {
                // выборка файлов в папке ru
                $files = scandir(public_path().$url_translate);
                // перебрать все файлы в папке
                foreach ($files as $key => $name) {
                    if (strripos($name, ".php") !== false) {
                        // содержимое файла
                        $arrProperties = include public_path().$url_translate.$name;
                        $prefix = substr($name, 0, strpos($name, "."));

                        $arrTranslate[mb_strtoupper($name_lang)][$prefix] = [];
                        foreach ($arrProperties as $property => $value) {
                            $arrTranslate[mb_strtoupper($name_lang)][$prefix][$property] = $value;
                        }
                    }
                }
            }
            else{
                // в других случаях беру en перевод
                $files = scandir(public_path() . $url_original);
                foreach ($files as $key => $name){
                    if (strripos($name, ".php") !== false) {
                        // содержимое файла
                        $arrProperties = include public_path() . $url_original.$name;
                        $prefix = substr($name, 0, strpos($name, "."));
                        $arrTranslate[mb_strtoupper($name_lang)][$prefix] = [];

                        foreach ($arrProperties as $property => $value){
                            $arrTranslate[mb_strtoupper($name_lang)][$prefix][$property] = $value;
                        }
                    }
                }
            }
        }

        return $arrTranslate;
    }

    /**
     * обновляю записи в базе для языков не RU и не EN (UK и другие файлы возможно были созданы в предыдущей работе с переводами)
     */
    private function updateTranslationIntoDatabase(){
        $translateCollection = GeographyTranslate::firstWhere('id', 1);
        $arrCountries = $this->updateArrayContent($this->url_country["translate"], $translateCollection->country);
        $arrRegions = $this->updateArrayContent($this->url_region["translate"], $translateCollection->regions);
        $arrCities = $this->updateArrayContent($this->url_city["translate"], $translateCollection->cities);

        GeographyTranslate::updateOrCreate(
            ['id' => '1'],
            [
                'country'=>$arrCountries,
                'regions'=>$arrRegions,
                'cities'=>$arrCities,
            ]
        );
    }

    private function updateArrayContent($url_translate, $rowDb) {
        $languages = config('site.locale.languages');

        // $name_lang - язык перевода
        foreach ($languages as $name_lang => $array) {

            // EN перезаписывается, поэтому смысла в обновлении значений Нет
            if($name_lang !== 'en'){
                // путь к папке перевода
                $url_dir_translate = public_path().$url_translate."$name_lang/";

                // что-то есть ?
                if (is_dir($url_dir_translate)) {
                    $files = scandir($url_dir_translate);

                    // перебрать все файлы в папке
                    foreach ($files as $key => $name) {
                        // только php файлы
                        if (strripos($name, ".php") !== false) {
                            // содержимое файла
                            $arrProperties = include $url_dir_translate.$name;
                            $prefix_country = substr($name, 0, strpos($name, "."));

                            // перебор записей файла
                            foreach ($arrProperties as $property => $value) {
                                // 1 замена значений в обьекте базы
                                $rowDb[mb_strtoupper($name_lang)][$prefix_country][$property] = $value;
                            }
                        }
                    }
                }
            }
        }

        return $rowDb;
    }

    private function returnNameCountry($array, $code){
        $nameReg = null;
        foreach ($array as $name => $arr) {
            // var_dump( $arr );
            if (array_search($code, array_column($arr, 'code')) !== false) {
                $nameReg = $name;
                break;
            }
        }
        return $nameReg;
    }

}
