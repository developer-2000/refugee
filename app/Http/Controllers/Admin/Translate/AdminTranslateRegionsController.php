<?php
namespace App\Http\Controllers\Admin\Translate;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateIndexRequest;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateUpdateRequest;
use App\Http\Traits\Admin\AdminTranslateLocationTrait;
use App\Model\GeographyDb;
use App\Model\GeographyTranslate;
use App\Services\LocalizationService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AdminTranslateRegionsController extends AdminBaseController {
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
        // колекция регионов оригинал
        $locationRegions = GeographyDb::select('regions')->firstWhere('id', 1);
        $allPrefix = $this->arrayElementsLowercaseUnderscore(array_keys($locationRegions->regions['EN']));
        $allRegions = (new LocalizationService())->getRegions($translate_lang, $locationRegions);

        // если есть сортировка по странам
        if(isset($request->country)){
            $allRegions = $this->filter($allRegions, 'prefix', $request->country);
        }

        $response = [
            "lang_arr"=>$langArr,
            "regions"=>$this->paginate($allRegions),
            "translate_lang"=>$translate_lang,
            "prefix_counties"=>$allPrefix,
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    public function update(AdminTranslateUpdateRequest $request){
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
        $full_url = config('site.locale.url_region')["translate"].mb_strtolower($request->translate_lang)."/";
        $this->makeFileTranslate(
            $workingArr[mb_strtoupper($request->translate_lang)][mb_strtolower($request->country)],
            $request->country,
            $full_url
        );

        Cache::forget(mb_strtolower($request->translate_lang).'_all_regions');

        return $this->getResponse();
    }

}
