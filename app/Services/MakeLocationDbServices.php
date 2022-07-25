<?php
namespace App\Services;

use App\Http\Traits\Geography\GeographyDbTraite;
use App\Http\Traits\Geography\GeographyFilesTraite;
use App\Model\GeographyDb;
use MenaraSolutions\Geographer\Earth;

// предназначен для заливки данных в базу - стран , регионов, городов
// инфа используется юзерами при указании своего адреса
class MakeLocationDbServices {
    use GeographyDbTraite, GeographyFilesTraite;

    protected $boolInsertDB = true;           // внести данные локации в базу
    protected $boolCreateFileNames = false;    // создавать файлы названий
    protected $earth;
    protected $lang;
    protected $settingsCountry;
    protected $arrLangCounty = [];
    protected $arrLangRegion = [];
    protected $arrLangCities = [];

    public function __construct() {
        $this->earth = new Earth();
        $this->lang = config('site.settings_location_db.lang');
        $this->settingsCountry = config('site.settings_location_db.country');
        $this->allCountry();
    }

    /**
 * сделать custom array стран
    языки [
        "RU" => страны [▼
            0 => страна [▼
                "code" => "AF"
                "name" => "Afghanistan"
     */
    public function allCountry() {
        $arrCountry = null;

        foreach ($this->lang as $key => $lang){
            // api все страны на указанном языке
            $all_county = $this->earth->getCountries()->setLocale($lang)->toArray();
            // создает custom array
            $arrCountry = $this->customArrCountry($all_county);
            $this->arrLangCounty[$lang] = $arrCountry;
        }

        if($this->boolInsertDB){
            GeographyDb::updateOrCreate(
                ['id' => '1'],
                ['country' => $this->arrLangCounty]
            );
        }
        if($this->boolCreateFileNames){
            $this->createFilesCountry($arrCountry);
        }

        // создать custom регионы стран на разных языках
        $this->allRegions();
    }

    /**
* заполнить регионами
    языки [
        "EN" => страны [
            "AF" => штаты [
                0 => штат [
                    "code" => 1121143,
                    "name" => "Zabul"
     */
    protected function allRegions () {
        $countryStates = [];

        // перебрать языки
        foreach ($this->lang as $key1 => $lang){
            $countryStates = [];
            // перебор стран отдает [ "code" => "AF", "name" => "Afghanistan"]
            foreach ($this->arrLangCounty[$lang] as $key2 => $arrCount){
                // найти эту страну в настройках нужных стран приложения
                if (array_search($arrCount["code"], $this->settingsCountry) !== false){
                    // создать custom масив regions
                    $customStates = $this->customArrStatesCountry($arrCount, $lang);
                    try {
                        // если есть штаты
                        if(count($customStates)){
                            // масив - код страны [ масив штатов ]
                            $countryStates[$arrCount["code"]] = $customStates;
                        }
                    } catch (\Exception $e) {
                        logger('Произошла ошибка - ' . $e->getMessage() . ' --- Файл - ' . $e->getFile() . ' --- Строка - ' . $e->getLine());
                    }
                }
            }

            $this->arrLangRegion[$lang] = $countryStates;
        }

        if($this->boolInsertDB){
            GeographyDb::updateOrCreate(
                ['id' => '1'],
                ['regions' => $this->arrLangRegion]
            );
        }
        if($this->boolCreateFileNames){
            $this->createFilesRegion($countryStates);
        }

        $this->allCities();
    }

    /**
     * язык + регион + города
     */
    protected function allCities () {

        // перебор языков
        foreach($this->lang as $key1 => $lang){
            // содержит регионы и их города на выбраном языке
            $arrayRegions = [];

            // перебор стран по code (внутри регионы)
            foreach ($this->arrLangRegion[$lang] as $codeCountry => $arrRegions){
                // найти эту страну в настройках нужных стран приложения
                if (array_search($codeCountry, $this->settingsCountry) !== false) {
                    // регионы и города в них
                    $response = $this->customArrCitiesRegions($codeCountry, $lang);

                    try {
                        // переберает регионы с выборкой городов
                        if (count($response)) {
                            $arrayRegions = $arrayRegions + $response;
                        }
                    } catch (\Exception $e) {
                        logger('Произошла ошибка - ' . $e->getMessage() . ' --- Файл - ' . $e->getFile() . ' --- Строка - ' . $e->getLine());
                    }
                }
            }
            $this->arrLangCities[$lang] = $arrayRegions;
        }

        if($this->boolInsertDB){
            GeographyDb::updateOrCreate(
                ['id' => '1'],
                ['cities' => $this->arrLangCities]
            );
        }
        if($this->boolCreateFileNames){
            $this->makeFilesCity($this->arrLangCities['EN'], '');
        }

        $this->arrLangCities = null;
        $this->arrLangRegion = null;
        $this->arrLangCounty = null;

        //    * записать в базу переводы локаций
        //    * ru переводы - страны, регионы (города в en)
        //    * en переводы - страны, регионы, города
        $this->enterTranslationIntoDatabase();
    }

}
