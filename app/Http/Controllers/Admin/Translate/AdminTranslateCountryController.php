<?php
namespace App\Http\Controllers\Admin\Translate;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateIndexRequest;
use App\Http\Requests\Admin\TranslateLocation\AdminTranslateUpdateRequest;
use App\Http\Traits\Admin\AdminTranslateLocationTrait;
use App\Model\GeographyDb;
use App\Model\GeographyTranslate;
use Illuminate\Http\Request;

class AdminTranslateCountryController extends AdminBaseController {
    use AdminTranslateLocationTrait;

    public function __construct() {
        parent::__construct();
    }

    public function index(AdminTranslateIndexRequest $request){
        // префиксы языков перевода
        $langArr = config('site.locale.languages');
        // колекции локации стран и их перевод
        $locationCountries = GeographyDb::select('country')->firstWhere('id', 1);
        $translateCountries = GeographyTranslate::select('country')->firstWhere('id', 1);
        $translate_lang = isset($request->language) ? $request->language : 'en';
        $arrContent = [];

        // перебрать переводы
        foreach ($translateCountries->country[mb_strtoupper($request->language)] as $prefix => $arrTranslate){
            $newArr = [];
            $array = $locationCountries->country['EN'];

            // найти в оригинале этот индекс
            foreach ($array as $item) {
                $found = array_filter($array, function($item) use ($prefix) {
                    return mb_strtoupper($prefix) == $item["code"];
                });
                if($found){
                    $index = mb_strtolower(current($found)['name']);
                    $newArr['prefix'] = str_replace(' ', '_', $index);
                    $newArr['original_index'] = str_replace(' ', '_', $index);
                    break;
                }
            }

            $newArr['prefix'] = mb_strtoupper($prefix);
            $newArr['translate_index'] = key($arrTranslate);
            $newArr['translate'] = current($arrTranslate);
            $arrContent[] = $newArr;
        }

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
        $full_url = config('site.locale.url_country')["translate"].mb_strtolower($request->translate_lang)."/";
        $this->makeFileCountry($property, $translate, $lowCountry, $full_url);

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
