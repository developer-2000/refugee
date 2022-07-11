<?php
namespace App\Http\Controllers\Admin\Translate;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateIndexRequest;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateUpdateRequest;
use App\Http\Traits\Admin\AdminTranslateLocationTrait;
use App\Model\GeographyDb;
use App\Model\GeographyTranslate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AdminTranslateCitiesController extends AdminBaseController {
    use AdminTranslateLocationTrait;

    protected $count_pagination = 0;

    public function __construct() {
        parent::__construct();
        $this->count_pagination = 50;
    }

    public function index(AdminTranslateIndexRequest $request){
        // префиксы языков перевода
        $langArr = config('site.locale.languages');
        $translate_lang = isset($request->language) ? $request->language : 'en';
        // колекция оригинал
        $locationCities_o = GeographyTranslate::select('cities')->firstWhere('id', 1);
        $allCities = [];

        // проверка кэшь
        if (!Cache::has($request->language.'_all_cities')) {

            // колекция перевода
            $translateCities_t = GeographyTranslate::select('cities')->firstWhere('id', 1);

            // перебрать страны перевода
            foreach ($translateCities_t->cities[mb_strtoupper($request->language)] as $prefix_country => $arrCities_t){
                $timeArr = [];

                // города страны оригинала
                $citiesCountry_o = $locationCities_o->cities['EN'][$prefix_country];
                // свойства городов оригинала
                $citiesArr_o = array_keys($citiesCountry_o);

                // перебрать города перевода
                foreach ($arrCities_t as $property_t => $value_region_t){
                    // 1 найдена или не найдена схожесть перевода с оригиналом (фиксирует ошибку)
                    $newArr = $this->searchOriginal($citiesCountry_o, $property_t);
                    $newArr['prefix'] = $prefix_country;
                    $newArr['translate_index'] = $property_t;
                    $newArr['translate'] = $value_region_t;
                    $timeArr[] = $newArr;

                    // удалить задействованный город
                    if(!isset($newArr['error_index'])){
                        $citiesArr_o = $this->removeSpecifiedElementFromArray($property_t, $citiesArr_o);
                    }
                }

                $timeArr = $this->sortingMultidimensionalArrayByKey($timeArr, 'translate_index');

                // добавить в случаи ошибок свойства не задействованных городов
                foreach ($timeArr as $index => $arr_city){
                    if( isset($arr_city["error_index"]) ){
                        $timeArr[$index]["error_index"] = $citiesArr_o;
                    }
                    $allCities[] = $timeArr[$index];
                }
            }

            Cache::put($request->language.'_all_cities', $allCities);
        }
        else{
            $allCities = Cache::get($request->language.'_all_cities');
        }

        // если есть сортировка по странам
        if(isset($request->country)){
            $allCities = $this->filter($allCities, 'prefix', $request->country);
        }

        $response = [
            "lang_arr"=>$langArr,
            "cities"=>$this->paginate($allCities),
            "translate_lang"=>$translate_lang,
            "prefix_cities"=>array_keys($locationCities_o->cities['EN']),
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    public function update(AdminTranslateUpdateRequest $request){
        $languagesCities = GeographyTranslate::select('cities')->firstWhere('id', 1)->cities;

        $workingArr = $languagesCities;
        // обьект языка
        $upLang = mb_strtoupper($request->translate_lang);
        $objLanguage = $workingArr[$upLang];
        // обьект страны
        $lowCountry = mb_strtolower($request->country);
        $updateObj = $objLanguage[$lowCountry];

        if($request->row == 'property'){
            $property = mb_strtolower(str_replace(" ", "_", $request->value));
            foreach ($updateObj as $prefix => $value_region){
                // нашел заменяемый елемент
                if($prefix == $request->old_property){
                    unset($workingArr[$upLang][$lowCountry][$prefix]);
                    $workingArr[$upLang][$lowCountry][$property] = $value_region;
                    break;
                }
            }
        }
        elseif($request->row == 'translate'){
            foreach ($updateObj as $prefix => $value_region){
                if($value_region == $request->old_value){
                    $workingArr[$upLang][$lowCountry][$prefix] = $request->value;
                    break;
                }
            }
        }

        // 1 обновить запись в базе
        GeographyTranslate::where('id', 1)->update([
            'cities'=>$workingArr
        ]);

        // 2 работает с файлом перевода города
        $full_url = config('site.locale.url_city')["translate"].mb_strtolower($request->translate_lang)."/";
        $this->makeFileTranslate(
            $workingArr[$upLang][$lowCountry],
            $request->country,
            $full_url
        );

        Cache::forget(mb_strtolower($request->translate_lang).'_all_cities');

        return $this->getResponse();
    }

    /**
     * найти в оригинале свойство перевода
     * @param $arrRegions
     * @param $search_property
     * @return array
     */
    private function searchOriginal($arrCities_o, $search_property){
        $newArr = [];
        // переберает города
        foreach ($arrCities_o as $property => $value){
            $value = mb_strtolower(str_replace(' ', '_', $value));
            // нашел свойство
            if($value == $search_property){
                $newArr['original_index'] = $value;
                break 1;
            }
        }
        // если совпадений свойства небыло
        if(!isset($newArr['original_index'])){
            $newArr['error_index'] = [];
        }

        return $newArr;
    }

}
