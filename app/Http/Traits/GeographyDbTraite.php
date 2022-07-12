<?php
namespace App\Http\Traits;

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
     * создает файлы стран в оригинале перевода
     * @param $array
     */
    private function createFileCountry($array){
        foreach ($array as $key => $arr){
            $line = "<?php \n\n  return [\n ";
            $prefix = $this->nameToAliasConversion($arr["name"]);
            $value = addslashes($arr["name"]);
            $line .= "'$prefix'=>'$value',\n ";
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
    private function createFileRegion($array){
        foreach ($array as $key_name => $arr){
            $line = "<?php \n\n  return [\n ";
            foreach ($arr as $index => $arr2){
                $prefix = $this->nameToAliasConversion($arr2["name"]);
                $value = addslashes($arr2["name"]);
                $line .= '"'.$prefix.'"=>"'.$value.'",'."\n";
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
        $arrCountries = [];

        // страны, регионы и города в них
        // ['UA'[ 686966[ "name" => "Zhytomyr", ...
        foreach ($array as $code_region => $arr_cities) {
            $prefix_country = $this->returnNameCountry($this->arrLangRegion['EN'], $code_region);

            // новый масив страны
            if(!isset($arrCountries[$prefix_country])){
                $arrCountries[$prefix_country] = [];
                $arrCountries[$prefix_country][$code_region] = [];
            }

            // внести этот регион с городами
            foreach($arr_cities as $index => $city){
                $arrCountries[$prefix_country][$code_region][] = ['name'=>$city["name"]];
            }

//            if($code_region == 698738){
//                dd( $arrCountries[$prefix_country] );
//            }
        }

        foreach ($arrCountries as $prefix_country => $arrRegions) {

            // создать файл страны
            $line = "<?php \n\n  return [\n ";
            foreach ($arrRegions as $code_region => $arrCities) {
                $line .= " '$code_region' => [\n ";
                // строка города
                foreach ($arrCities as $index => $city) {
                    $prefix = $this->nameToAliasConversion($city["name"]);
                    $name = addslashes($city["name"]);
                    $line .= '"'.$prefix.'"=>"'.$name.'",'."\n";
                }
                $line .= " ], \n";
            }
            $line .= "];";

            $code_country = mb_strtolower($prefix_country);
            file_put_contents(public_path().$this->url_city['original'].$code_country.".php", $line);
        }
    }

    /**
     * записать в базу переводы локаций
     * ru переводы - страны, регионы (города в en)
     * en переводы - страны, регионы, города
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
     * логика формирования переводов в базе
     * @param $url_translate
     * @param $url_original
     * @return array
     */
    private function makeArrayContent($url_translate, $url_original) {
        $url_translate = $url_translate."ru/";
        $arrTranslate = [];
        $languages = config('site.locale.languages');

        // перебераю все языки перевода
        foreach ($languages as $prefix_lang => $array) {
            // 1 создается префикс перевода
            $arrTranslate[mb_strtoupper($prefix_lang)] = [];

            if ($prefix_lang === 'ru' || $prefix_lang === 'uk') {

                // готовый перевод был создан руками - ru залить в ru и uk (страны и регионы)
                $path = public_path().$url_translate;
                if($this->checkingPathExists($path)){
                    $arrTranslate = $this->writeFromFileToDatabase($path, $prefix_lang, $arrTranslate);
                }
                // перевод ru не был создан для городов. залить en перевод в города
                else{
                    $path = public_path().$url_original;
                    $arrTranslate = $this->writeFromFileToDatabase($path, $prefix_lang, $arrTranslate);
                }
            }
            else{
                $path = public_path().$url_original;
                $arrTranslate = $this->writeFromFileToDatabase($path, $prefix_lang, $arrTranslate);
            }
        }

        return $arrTranslate;
    }

    /**
     * выборка файлов и формирование обьекта для базы
     * @param $path
     * @param $prefix_lang
     * @param $arrTranslate
     * @return mixed
     */
    private function writeFromFileToDatabase($path, $prefix_lang, $arrTranslate) {
        if($this->checkingPathExists($path)){
            // в других случаях беру en перевод
            $files = scandir($path);
            foreach ($files as $key => $name){
                if (strripos($name, ".php") !== false) {
                    // содержимое файла
                    $arrProperties = include $path.$name;
                    $prefix_country = substr($name, 0, strpos($name, "."));
                    $arrTranslate[mb_strtoupper($prefix_lang)][$prefix_country] = [];

                    foreach ($arrProperties as $property => $value){
                        $arrTranslate[mb_strtoupper($prefix_lang)][$prefix_country][$property] = $value;
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

    // преобразует название страны, города в рабочий alias
    private function nameToAliasConversion($name){
        $prefix = mb_strtolower($name);
        $prefix = str_replace(" ", "-", $prefix);
        $prefix = str_replace("'", "", $prefix);
        $prefix = str_replace("’", "", $prefix);
        $prefix = str_replace(",", "", $prefix);
        $prefix = str_replace(".", "", $prefix);
        return $prefix;
    }

    // проверка существования пути
    private function checkingPathExists($path){
        if (!is_dir($path)) {
            return false;
        }
        return true;
    }

}
