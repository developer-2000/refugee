<?php
namespace App\Http\Controllers\Admin\Translate;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateIndexRequest;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateUpdateRequest;
use App\Http\Traits\Admin\AdminTranslateLocationTrait;
use App\Http\Traits\Geography\GeographyFilesTraite;
use App\Model\GeographyTranslate;
use App\Services\LocalizationService;
use Illuminate\Support\Facades\Cache;

class AdminTranslateCitiesController extends AdminBaseController {
    use AdminTranslateLocationTrait, GeographyFilesTraite;

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
        $locationCities = GeographyTranslate::select('cities')->firstWhere('id', 1);
        $allPrefix = array_keys($locationCities->cities['EN']);

        $allCities = (new LocalizationService())->getCities($translate_lang);

        // если есть сортировка по странам
        if(isset($request->country)){
            $allCities = $this->filter($allCities, 'prefix', $request->country);
        }

        $response = [
            "lang_arr"=>$langArr,
            "cities"=>$this->paginate($allCities),
            "translate_lang"=>$translate_lang,
            "prefix_cities"=>$allPrefix,
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    public function update(AdminTranslateUpdateRequest $request){
        $languagesCities = GeographyTranslate::select('cities')->firstWhere('id', 1)->cities;
        $up_lang = mb_strtoupper($request->translate_lang);
        $low_country = mb_strtolower($request->country);
        $workingArr = $languagesCities;
        $objCountry = $workingArr[$up_lang][$low_country];
        $url_city = config('site.locale.url_city');

        if($request->row == 'property'){
            $new_property = $this->nameToAliasConversion($request->value);
            foreach ($objCountry as $code_region => $arrCities){
                foreach ($arrCities as $property_city => $value_city){
                    // нашел заменяемый елемент
                    if($property_city == $request->old_property){
                        unset( $workingArr[$up_lang][$low_country][$code_region][$property_city] );
                        $workingArr[$up_lang][$low_country][$code_region][$new_property] = $value_city;
                        break 2;
                    }
                }
            }
        }
        elseif($request->row == 'translate'){
            foreach ($objCountry as $code_region => $arrCities){
                foreach ($arrCities as $property_city => $value_city){
                    // нашел заменяемый елемент
                    if($value_city == $request->old_value){
                        $value = addslashes($request->value);
                        $workingArr[$up_lang][$low_country][$code_region][$property_city] = $value;
                        break 2;
                    }
                }
            }
        }

        // 1 обновить запись в базе
        GeographyTranslate::where('id', 1)->update([
            'cities'=>$workingArr
        ]);

        // 2 работает с файлом перевода города
//        $full_url = config('site.locale.url_city')["translate"].mb_strtolower($request->translate_lang)."/";
//        $this->makeFileTranslate(
//            $workingArr[$up_lang][$low_country],
//            $request->country,
//            $full_url
//        );

        $this->createFileCity(
            $workingArr[$up_lang][$low_country],
            $request->country,
            public_path().$url_city['translate'].mb_strtolower($request->translate_lang).'/'
        );

        Cache::forget(mb_strtolower($request->translate_lang).'_all_cities');

        return $this->getResponse();
    }

}
