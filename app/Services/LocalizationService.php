<?php
namespace App\Services;

use App\Http\Traits\Admin\AdminTranslateLocationTrait;
use App\Model\GeographyDb;
use App\Model\GeographyTranslate;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class LocalizationService {
    use AdminTranslateLocationTrait;

    protected $lang_now;

    public function __construct() {
        $this->lang_now = App::getLocale();
    }

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

    /**
     * Все страны языка
     * @param $prefix_lang
     * @return array|mixed
     */
    public function getCountries($prefix_lang) {
        $arrContent = [];

//        Cache::forget($prefix_lang.'_all_countries');

        if (!Cache::has($prefix_lang.'_all_countries')) {
            // колекции стран и их перевод
            $locationCountries = GeographyDb::select('country')->firstWhere('id', 1);
            $translateCountries_t = GeographyTranslate::select('country')->firstWhere('id', 1);

            // перебрать переводы
            foreach ($translateCountries_t->country[mb_strtoupper($prefix_lang)] as $prefix_t => $arrTranslate_t){
                $newArr = [];
                $array_o = $locationCountries->country['EN'];

                // найти в оригинале этот индекс
                foreach ($array_o as $item) {
                    $found_o = array_filter($array_o, function($item) use ($prefix_t) {
                        return mb_strtoupper($prefix_t) == $item["code"];
                    });
                    if($found_o){
                        $index = mb_strtolower(current($found_o)['name']);
                        $index = $this->nameToAliasConversion($index);
                        $newArr['prefix'] = $index;
                        $newArr['original_index'] = $index;
                        break;
                    }
                }

                $newArr['prefix'] = mb_strtoupper($prefix_t);
                $newArr['translate_index'] = key($arrTranslate_t);
                $newArr['translate'] = current($arrTranslate_t);
                $arrContent[] = $newArr;
            }

            $arrContent = array_values(collect($arrContent)->sortBy('translate')->toArray());

            Cache::put($prefix_lang.'_all_countries', $arrContent);
        }
        else{
            $arrContent = Cache::get($prefix_lang.'_all_countries');
        }

        return $arrContent;
    }

    /**
     * Все регионы языка
     * @param $prefix_lang
     * @param $locationRegions_o
     * @return array|mixed
     */
    public function getRegions($prefix_lang) {
        $allRegions = [];

//        Cache::forget($prefix_lang.'_all_regions');

        // проверка кэшь
        if (!Cache::has($prefix_lang.'_all_regions')) {
            // колекция регионов перевода
            $translateRegions = GeographyTranslate::select('regions')->firstWhere('id', 1);
            $locationRegions_o = GeographyDb::select('regions')->firstWhere('id', 1);


            // перебрать страны языка
            foreach ($translateRegions->regions[mb_strtoupper($prefix_lang)] as $prefix_country => $arrRegions){
                $timeArr = [];

                $regionsCountry_o = $locationRegions_o->regions['EN'][mb_strtoupper($prefix_country)];
                // трансформированые имена регионов
                $regionArr = collect($regionsCountry_o)->pluck('name')->toArray();
                $regionArr = $this->arrayElementsLowercaseUnderscore($regionArr);

                // перебрать регионы страны
                foreach ($arrRegions as $property_region => $value_region){

                    // 1 найдена или не найдена схожесть перевода с оригиналом (фиксирует ошибку)
                    $newArr = $this->searchOriginal($regionsCountry_o, $property_region);
                    $newArr['prefix'] = $prefix_country;
                    $newArr['translate_index'] = $property_region;
                    $newArr['translate'] = $value_region;
                    $timeArr[] = $newArr;

                    // оставить только не задействованный регионы
                    if(!isset($newArr['error_index'])){
                        $regionArr = $this->removeSpecifiedElementFromArray($property_region, $regionArr);
                    }
                }

                $timeArr = $this->sortingMultidimensionalArrayByKey($timeArr, 'translate_index');

                // добавить в случаи ошибок свойства не задействованных регионов
                foreach ($timeArr as $key => $arr_region){
                    if( isset($arr_region["error_index"]) ){
                        $timeArr[$key]["error_index"] = $regionArr;
                    }
                    $allRegions[] = $timeArr[$key];
                }
            }

            Cache::put($prefix_lang.'_all_regions', $allRegions);
        }
        else{
            $allRegions = Cache::get($prefix_lang.'_all_regions');
        }

        return $allRegions;
    }

    /**
     * Все города языка
     * @param $prefix_lang
     * @return array|mixed
     */
    public function getCities($prefix_lang) {
        $allCities = [];

//        Cache::forget($prefix_lang.'_all_cities');

        // проверка кэшь
        if (!Cache::has($prefix_lang.'_all_cities')) {
            $locationCities = GeographyTranslate::select('cities')->firstWhere('id', 1);

            // колекция перевода
            $translateCities_t = $locationCities;
            $originalCities_o = GeographyDb::select('cities')->firstWhere('id', 1)->cities;

            // перебрать страны перевода
            foreach ($translateCities_t->cities[mb_strtoupper($prefix_lang)] as $prefix_country => $arrRegions_t){
                $count = [];
                // перебрать регионы страны
                foreach ($arrRegions_t as $code_region => $arrCities_t){
                    $region = [];
                    // конвертированыые value городов оригинала
                    $propertyCities_o = $originalCities_o['EN'][$code_region];
                    if(is_array($propertyCities_o) && count($propertyCities_o)){
                        $propertyCities_o = collect($propertyCities_o)->pluck('name');
                        $propertyCities_o = $this->arrayElementsLowercaseUnderscore( $propertyCities_o->toArray() );

                        // перебрать города региона
                        foreach ($arrCities_t as $property_city_t => $value_city_t){
                            // 1 найдена или не найдена схожесть перевода с оригиналом (фиксирует ошибку)
                            $city = $this->searchOriginal($propertyCities_o, $property_city_t);
                            $city['prefix'] = $prefix_country;
                            $city['translate_index'] = $property_city_t;
                            $city['translate'] = $value_city_t;
                            $city['code_region'] = $code_region;
                            $region[] = $city;

                            // удалить задействованный город
                            if(!isset($city['error_index'])){
                                $propertyCities_o = $this->removeSpecifiedElementFromArray($property_city_t, $propertyCities_o);
                            }
                        }
                        // добавить в случаи ошибок свойства не задействованных городов
                        foreach ($region as $index => $city){
                            if( isset($city["error_index"]) ){
                                $region[$index]["error_index"] = $propertyCities_o;
                            }
                            $count[] = $region[$index];
                        }
                    }
                }

                $count = $this->sortingMultidimensionalArrayByKey($count, 'translate_index');
                $allCities = array_merge($allCities, $count);
            }

            Cache::put($prefix_lang.'_all_cities', $allCities);
        }
        else{
            $allCities = Cache::get($prefix_lang.'_all_cities');
        }

        return $allCities;
    }

    /**
     * выбрать обьект страны по префиксу
     * @param $prefix_count
     * @return mixed|null
     */
    public function getCountryForShow($prefix_count){
        $countries = $this->getCountries($this->lang_now);
        $country = null;
        foreach ($countries as $key => $arr){
            if($arr["prefix"] === $prefix_count){
                $country = $arr;
                break;
            }
        }
        return $country;
    }

    /**
     * выбрать обьект города по
     * @param $arrRegion
     * @return mixed|null
     */
    public function getRegionForShow($arrRegion){
        $regions = $this->getRegions($this->lang_now);
        $region = null;
        foreach ($regions as $key => $arr){
            if(isset($arr["code_region"]) && $arr["code_region"] === $arrRegion["code_region"]){
                $region = $arr;
                break;
            }
        }
        return $region;
    }

    /**
     * выбрать обьект города по данным обьекта коллекции
     * @param $arrCity
     * @return mixed|null
     */
    public function getCityForShow($arrCity){
        $cities = $this->getCities($this->lang_now);
        $city = null;
        foreach ($cities as $key => $arr){
            if(isset($arr["code_region"]) && isset($arr["original_index"])){
                if($arr["code_region"] === $arrCity["code_region"] && $arr["original_index"] === $arrCity["original_index"]){
                    $city = $arr;
                    break;
                }
            }
        }
        return $city;
    }

}
