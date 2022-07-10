<?php
namespace App\Http\Controllers\Admin\Translate;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\TranslateLocation\AdminIndexRequest;
use App\Http\Requests\Admin\TranslateLocation\AdminUpdateRequest;
use App\Model\GeographyDb;
use App\Model\GeographyTranslate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AdminTranslateRegionsController extends AdminBaseController {

    protected $count_pagination = 0;

    public function __construct() {
        parent::__construct();
        $this->count_pagination = 50;
    }

    public function index(AdminIndexRequest $request){
        // префиксы языков перевода
        $langArr = config('site.locale.languages');
        $translate_lang = isset($request->language) ? $request->language : 'en';
        // колекция регионов оригинал
        $locationRegions = GeographyDb::select('regions')->firstWhere('id', 1);
        $allRegions = [];

        // проверка кэшь
        if (!Cache::has($request->language.'_all_regions')) {
            // колекция регионов перевода
            $translateRegions = GeographyTranslate::select('regions')->firstWhere('id', 1);

            // перебрать страны языка
            foreach ($translateRegions->regions[mb_strtoupper($request->language)] as $prefix_country => $arrRegions){
                // временный масив регионов страны
                $timeArr = [];
                $regionsCountry = $locationRegions->regions['EN'][mb_strtoupper($prefix_country)];
                // выбрать все регионы страны
                $regionArr = collect($regionsCountry)->pluck('name')->toArray();
                $regionArr = $this->arrayElementsLowercaseUnderscore($regionArr);

                // перебрать регионы страны
                foreach ($arrRegions as $property_region => $value_region){
                    // 1 найдена или не найдена схожесть перевода с оригиналом (фиксирует ошибку)
                    $newArr = $this->searchOriginal($regionsCountry, $property_region);
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

            Cache::put($request->language.'_all_regions', $allRegions);
        }
        else{
            $allRegions = Cache::get($request->language.'_all_regions');
        }

        // если есть сортировка по странам
        if(isset($request->country)){
            $allRegions = $this->filter($allRegions, 'prefix', $request->country);
        }

        $response = [
            "lang_arr"=>$langArr,
            "regions"=>$this->paginate($allRegions),
            "translate_lang"=>$translate_lang,
            "prefix_counties"=>$this->arrayElementsLowercaseUnderscore(array_keys($locationRegions->regions['EN'])),
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    /**
     * найти в оригинале свойство региона перевода
     * @param $arrRegions
     * @param $search_property
     * @return array
     */
    private function searchOriginal($arrRegions, $search_property){
        $newArr = [];
        // переберает регионы
        foreach ($arrRegions as $index => $arr){
            $property = mb_strtolower(str_replace(' ', '_', $arr["name"]));
            // нашел свойство региона
            if($property == $search_property){
                $newArr['original_index'] = $property;
                break 1;
            }
        }
        // если совпадений свойства небыло
        if(!isset($newArr['original_index'])){
            $newArr['error_index'] = [];
        }

        return $newArr;
    }

    /**
     * custom paginate for array
     * @param $translateRegions
     * @param $prefix_lang
     * @return int
     */
    public function paginate($items, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->count_pagination), $items->count(), $this->count_pagination, $page, $options);
    }

    public function update(AdminUpdateRequest $request){
        $languageCountries = GeographyTranslate::select('regions')->firstWhere('id', 1)->regions;
        $workingArr = $languageCountries;
        // обьект языка - EN
        $objLanguage = $workingArr[mb_strtoupper($request->translate_lang)];
        // обьект страны - ua
        $updateObj = $objLanguage[mb_strtolower($request->country)];

        if($request->row == 'property'){
            $property = mb_strtolower(str_replace(" ", "_", $request->value));
            foreach ($updateObj as $prefix_region => $value_region){
                if($prefix_region == $request->old_property){
                    unset($workingArr[mb_strtoupper($request->translate_lang)][mb_strtolower($request->country)][$prefix_region]);
                    $workingArr[mb_strtoupper($request->translate_lang)][mb_strtolower($request->country)][$property] = $value_region;
                    break;
                }
            }
        }
        elseif($request->row == 'translate'){
            foreach ($updateObj as $prefix_region => $value_region){
                if($value_region == $request->old_value){
                    $workingArr[mb_strtoupper($request->translate_lang)][mb_strtolower($request->country)][$prefix_region] = $request->value;
                    break;
                }
            }
        }

        // 1 обновить запись в базе
        GeographyTranslate::where('id', 1)->update([
            'regions'=>$workingArr
        ]);

        // 2 работает с файлом перевода региона
        $this->makeFileRegions(
            $workingArr[mb_strtoupper($request->translate_lang)][mb_strtolower($request->country)],
            $request->country,
            mb_strtolower($request->translate_lang)
        );

        Cache::forget(mb_strtolower($request->translate_lang).'_all_regions');

        return $this->getResponse();
    }

    /**
     * работает с файлом перевода регионов
     * @param $arrRegions
     * @param $country
     * @param $lang
     */
    private function makeFileRegions($arrRegions, $country, $lang){
        $url_region = config('site.locale.url_region')["translate"]."$lang/";

        $line = "<?php \n\n  return [\n ";
        foreach ($arrRegions as $prefix_region => $value_region){
            $prefix = addslashes($prefix_region);
            $value = addslashes($value_region);
            $line .= "'$prefix'=>'$value',\n ";
        }
        $line .= "];";

        $this->createDir(public_path().$url_region);
        file_put_contents(public_path() . $url_region. $country.".php", $line);
    }

    /**
     * создать папку если не существует
     * @param $path
     */
    private function createDir($path){
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    /**
     * елементы масива в нижнем регистре, пробелы подчеркнуты
     * @param $regionArr
     * @return string|string[]
     */
    private function arrayElementsLowercaseUnderscore($regionArr){
        $regionArr = str_replace(" ", "_", $regionArr);
        foreach ($regionArr as $k => $v) {
            $regionArr[$k] = mb_strtolower($v);
        }
        return $regionArr;
    }

    private function removeSpecifiedElementFromArray($property_region, $regionArr){
        $key = array_search($property_region, $regionArr);
        if($key !== false){
            unset($regionArr[$key]);
            $regionArr = array_values($regionArr);
        }
        return $regionArr;
    }

    /**
     * сортировка многомерного масива по ключу
     * @param $array
     * @param $key
     * @return mixed
     */
    private function sortingMultidimensionalArrayByKey($array, $key){
        usort($array, function($a,$b) use ($key){
            return ($a[$key] > $b[$key]);
        });
        return $array;
    }

    private function filter($array, $index, $value){
        $array = array_filter($array, function ($item) use ($value, $index) {
            return $item[$index] == $value;
        });
        return $array;
    }


}
