<?php
namespace App\Http\Controllers\Admin\Translate;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateIndexRequest;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateUpdateRequest;
use App\Http\Traits\Admin\AdminTranslateLocationTrait;
use App\Model\GeographyTranslate;
use App\Services\LocalizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminTranslateCountryController extends AdminBaseController {
    use AdminTranslateLocationTrait;

    public function __construct() {
        parent::__construct();
    }

    public function index(AdminTranslateIndexRequest $request){
        // префиксы языков перевода
        $langArr = config('site.locale.languages');
        $translate_lang = isset($request->language) ? $request->language : 'en';
        $arrContent = (new LocalizationService())->getCountries($translate_lang);

        $response = [
            "lang_arr"=>$langArr,
            "countries"=>$arrContent,
            "translate_lang"=>$translate_lang,
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    public function update(AdminTranslateUpdateRequest $request){
        $languageCountries = GeographyTranslate::select('country')->firstWhere('id', 1)->country;
        $workingArr = $languageCountries;
        // обьект языка - EN
        $upLanguage = mb_strtoupper($request->translate_lang);
        $objLanguage = $workingArr[$upLanguage];
        // обьект страны - ua
        $lowCountry = mb_strtolower($request->country);
        $updateObj = $objLanguage[$lowCountry];
        $newObj = [];
        $property = '';
        $translate = '';

        if($request->row == 'property'){
            $property = mb_strtolower(str_replace(" ", "_", $request->value));
            $translate = current((Array)$updateObj);
            $newObj = [
                $property => $translate
            ];
        }
        elseif($request->row == 'translate'){
            $property = array_key_first((Array)$updateObj);
            $translate = $request->value;
            $newObj = [
                $property => $translate
            ];
        }

        $objLanguage[$lowCountry] = $newObj;
        $workingArr[$upLanguage] = $objLanguage;

        // 1 обновить запись в базе
        GeographyTranslate::where('id', 1)->update([
            'country'=>$workingArr
        ]);
        // 2 работает с файлом перевода страны
        $lowLanguage = mb_strtolower($request->translate_lang);
        $full_url = config('site.locale.url_country')["translate"].$lowLanguage."/";
        $this->makeFileCountry($property, $translate, $lowCountry, $full_url);

        Cache::forget($lowLanguage.'_all_countries');

        return $this->getResponse();
    }

    /**
     * работает с файлом перевода страны
     * @param $property
     * @param $translate
     * @param $country
     * @param $full_url
     */
    private function makeFileCountry($property, $translate, $country, $full_url){
        $line = "<?php \n\n  return [\n ";
        $property = addslashes($property);
        $translate = addslashes($translate);
        $line .= "'$property'=>'$translate',\n ";
        $line .= "];";

        $this->createDir(public_path().$full_url);
        file_put_contents(public_path() . $full_url.$country.".php", $line);
    }

}
