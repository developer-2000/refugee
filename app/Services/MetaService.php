<?php
namespace App\Services;

use Butschster\Head\Facades\Meta;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Illuminate\Support\Facades\App;

class MetaService {

    /**
     * страница index сайта
     */
    public function setMetaIndexPage(){
        $this->metaTags([
            "title" => __('meta_tags.index_page.title').config('app.name', ""),
            "description" => config('app.name', "").__('meta_tags.index_page.description'),
            "keywords" => __('meta_tags.index_page.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница - о нас
     */
    public function setMetaAboutUsPage(){
        $this->metaTags([
            "title" => __('meta_tags.about_us.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.about_us.description', [ "app_name"=>config('app.name', "") ]),
            "keywords" => __('meta_tags.about_us.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница связи
     */
    public function setMetaFeedbackPage(){
        $this->metaTags([
            "title" => __('meta_tags.feedback.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.feedback.description').config('app.name', ""),
            "keywords" => __('meta_tags.feedback.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }


    public function setMetaCustomerSurveyPage(){
        $this->metaTags([
            "title" => __('meta_tags.survey.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.survey.description').config('app.name', ""),
            "keywords" => __('meta_tags.survey.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница пользовательское соглашение
     */
    public function setMetaTermsUsePage(){
        $this->metaTags([
            "title" => __('meta_tags.terms_use.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.terms_use.description').config('app.name', ""),
            "keywords" => __('meta_tags.terms_use.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница cookie police
     */
    public function setMetaCookiePolicyPage(){
        $this->metaTags([
            "title" => __('meta_tags.cookie_policy.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.cookie_policy.description').config('app.name', ""),
            "keywords" => __('meta_tags.cookie_policy.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница доната
     */
    public function setMetaCharityPage(){
        $this->metaTags([
            "title" => __('meta_tags.charity.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.charity.description').config('app.name', ""),
            "keywords" => __('meta_tags.charity.keywords').config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страницы поиска вакансий
     * @param $boolArr
     */
    public function setMetaAllVacanciesPage($boolArr){
        $location_now = $this->checkLocation($boolArr);

        // 1 все вакансии
        if( $location_now === "all_documents" ){
            $this->metaTags([
                "title" => __('meta_tags.all_vacancies.title').config('app.name', ""),
                "description" => __('meta_tags.all_vacancies.description'),
                "keywords" => __('meta_tags.all_vacancies.keywords').config('site.meta.keywords', ""),
                "canonical" => url()->current(),
            ]);
        }
        // 2 вакансии страны
        elseif ( $location_now === "country" ){
            $this->metaTags([
                "title" => __('meta_tags.vacancies_country.title', ['name' => $boolArr["now_country"]["translate"]])." - ".config('app.name', ""),
                "description" =>__('meta_tags.vacancies_country.description', ['name' => $boolArr["now_country"]["translate"]]).config('app.name', ""),
                "keywords" => __('meta_tags.vacancies_country.keywords', ['name' => $boolArr["now_country"]["translate"]]).config('site.meta.keywords', ""),
                "canonical" => url()->current(),
            ]);
        }
        // 3 вакансии региона или города
        elseif ( $location_now === "city" ){
            $city = !is_null($boolArr["now_city"]) ? $boolArr["now_city"]["translate"] : $boolArr["now_region"]["translate"];

            $this->metaTags([
                "title" => __('meta_tags.vacancies_city.title', [
                        'city' => $city,
                        'country' => $boolArr["now_country"]["translate"]
                    ]).config('app.name', ""),
                "description" =>  __('meta_tags.vacancies_city.description', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"], ]).config('app.name', ""),
                "keywords" => __('meta_tags.vacancies_city.keywords', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"], ]).config('site.meta.keywords', ""),
                "canonical" => url()->current(),
            ]);
        }
    }

    /**
     * страница указаной вакансии
     * @param $vacancy
     */
    public function setMetaShowVacancyPage($vacancy){
        $salary = ($vacancy["salary"]["radio_name"] == "range") ?
            ($vacancy["salary"]["inputs"]["from"]." - ".$vacancy["salary"]["inputs"]["to"]) :
            (($vacancy["salary"]["radio_name"] == "single_value") ? $vacancy["salary"]["inputs"]["salary_sum"] : "");
        $address = isset($vacancy["address"]["city"]) ? $vacancy["address"]["city"]["translate"] : $vacancy["address"]["region"]["translate"];
        $user_name = $vacancy['contact']['full_name'];

        $this->metaTags([
            "title" => __('meta_tags.show_vacancy.title', [
                    'title' => $vacancy["position"]["title"],
                    'salary' => $salary,
                    'user_name' => $user_name,
                ]).config('app.name', ""),
            "description" => __(
                'meta_tags.show_vacancy.description',
                [
                    'company' => $vacancy["company"]["title"],
                    'title' => $vacancy["position"]["title"],
                    'salary' => $salary, 'address' => $address,]
                ).config('app.name', ""),
            "keywords" => __('meta_tags.show_vacancy.keywords', [ 'address' => $address]).config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);

    }

    /**
     * страницы поиска резюме
     * @param $boolArr
     */
    public function setMetaAllResumesPage($boolArr){
        $location_now = $this->checkLocation($boolArr);

        // 1 все резюме
        if( $location_now === "all_documents" ){
            $this->metaTags([
                "title" => __('meta_tags.all_resumes.title').config('app.name', ""),
                "description" =>  config('app.name', "").__('meta_tags.all_resumes.description'),
                "keywords" => __('meta_tags.all_resumes.keywords').config('site.meta.keywords', ""),
                "canonical" => url()->current(),
            ]);
        }
        // 2 резюме страны
        elseif ( $location_now === "country" ){
            $this->metaTags([
                "title" => __('meta_tags.resumes_country.title', ["country"=>$boolArr["now_country"]["translate"]]).config('app.name', ""),
                "description" => __('meta_tags.resumes_country.description', [ "country"=>$boolArr["now_country"]["translate"], "site"=>config('app.name', "") ]),
                "keywords" => __('meta_tags.resumes_country.keywords', [ "country"=>$boolArr["now_country"]["translate"] ]).config('site.meta.keywords', ""),
                "canonical" => url()->current(),
            ]);
        }
        // 3 резюме региона или города
        elseif ( $location_now === "city" ){
            $city = !is_null($boolArr["now_city"]) ? $boolArr["now_city"]["translate"] : $boolArr["now_region"]["translate"];
            $this->metaTags([
                "title" => __('meta_tags.resumes_city.title', [
                        "city"=>$city,
                        'country' => $boolArr["now_country"]["translate"]
                    ]).config('app.name', ""),
                "description" => __('meta_tags.resumes_city.description', ["city"=>$city, "country"=>$boolArr["now_country"]["translate"], ]).config('app.name', ""),
                "keywords" => __('meta_tags.resumes_city.keywords', ["city"=>$city, "country"=>$boolArr["now_country"]["translate"], ]).config('site.meta.keywords', ""),
                "canonical" => url()->current(),
            ]);
        }


    }

    /**
     * страница указаной резюме
     * @param $resume
     */
    public function setMetaShowResumePage($resume){
        $address = isset($resume["address"]["city"]) ? $resume["address"]["city"]["translate"] : $resume["address"]["region"]["translate"];
        $user_name = $resume['contact']['full_name'];

        $this->metaTags([
            "title" => __('meta_tags.show_resume.title', [
                    "title"=>$resume["position"]["title"],
                    "address"=>$address,
                    'user_name' => $user_name
                ]).config('app.name', ""),
            "description" => __('meta_tags.show_resume.description', [ "title"=>$resume["position"]["title"], "address"=>$address, ]).config('app.name', ""),
            "keywords" => __('meta_tags.show_resume.keywords', [ "address"=>$address ]).config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница указаной компании
     * @param $resume
     */
    public function setMetaShowCompanyPage($company){
        $this->metaTags([
            "title" => __('meta_tags.show_company.title', [ "company"=>$company["title"] ]).config('app.name', ""),
            "description" => __('meta_tags.show_company.description', [ "company"=>$company["title"] ]).config('app.name', ""),
            "keywords" =>  __('meta_tags.show_company.keywords', [ "company"=>$company["title"] ]).config('site.meta.keywords', ""),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * установка мета тегов OpenGraph
     * @param $config
     */
    public function setOpenGraph($config){
        $service = new LanguageService();
        // выбрать префикс языка страницы
        $prefix_lang = $service->selectLangFromUrl();
        $arrLanguages = config('site.locale.languages');
        $og = new OpenGraphPackage('open_graph');

        $og->setUrl(url()->current())
            ->setTitle($config["title_page"])
            ->setDescription($config["description"])
            ->setType('article')
            ->setSiteName($config['app_domain'])
            ->addImage($config['app_url']."/img/sharing/sharing-logo.jpg",
                [
                    'type' => 'image/jpg',
                    'width' => '1200',
                    'height' => '630',
                ]
            );

        // установить локаль страницы
        foreach ($arrLanguages as $key => $arr){
            if($key === $prefix_lang){
                $og->setLocale($arr[1]);
            }
            else{
                $og->addAlternateLocale($arr[1]);
            }
        }

        Meta::registerPackage($og);
    }

    /**
     * установка мета тегов TwitterCard
     * @param $config
     */
    public function setTwitterCard($config){
        $card = new TwitterCardPackage('twitter');

        $card->setType('summary_large_image')
            ->setTitle($config["title_page"])
            ->setDescription($config["description"])
            ->setImage($config['app_url']."/img/sharing/sharing-logo.jpg",
                [
                    'type' => 'image/jpg',
                    'width' => '1200',
                    'height' => '630',
                ]
            )
            ->addMeta('image:alt', 'Logotype Site');

        Meta::registerPackage($card);
    }


    /**
     * определяет по url локационный поиск
     * @param $dataArr
     * @return string
     */
    public function checkLocation($dataArr){
        // 1 все вакансии
        if( is_null($dataArr["now_country"]) ){
            return "all_documents";
        }
        // 2 вакансии страны
        elseif ( !is_null($dataArr["now_country"]) && (is_null($dataArr["now_region"]) && is_null($dataArr["now_city"])) ){
            return "country";
        }
        // 3 вакансии региона или города
        elseif ( !is_null($dataArr["now_region"]) || !is_null($dataArr["now_city"]) ){
            return "city";
        }
    }

    /**
     * формирует мета теги страницы
     * @param  MetaService  $meta
     * @param $data
     * @param  null  $name_page
     */
    private function metaTags($data){
        Meta::setTitle($data["title"])
            ->setDescription($data["description"])
            ->setCanonical($data["canonical"])
            ->setKeywords($data["keywords"]);

        $hrefs = $this->getArrHreflang();

        foreach ($hrefs as $key => $arr) {
            Meta::setHrefLang($arr["hreflang"], $arr["href"]);
        }
    }

    /**
     * Формирует масив Hreflang для Мета тегов
     * @return array
     */
    private function getArrHreflang() {
        // языки переводов сайта
        $prefix_translate = config("app.alternative_lang");
        //[ "scheme" => "http", "host" => "refugee", "path" => "/ru" ]
        $boneUrl = parse_url(url()->current());
        $path = "";
        $arrTranslate = [];

        if(isset($boneUrl["path"])){
            $path = $boneUrl["path"];
            $start_line = substr($path, 1, 2);
            // удалить префикс языка из $path
            if (in_array($start_line, $prefix_translate)) {
                $path = substr($path, 3);
                $path = $path !== "" ? $path : "";
            }
        }

        foreach ($prefix_translate as $key => $prefix){
            $arrTranslate[] = [
                "href" => $boneUrl["scheme"]."://".$boneUrl["host"]."/".$prefix.$path,
                "hreflang" => $prefix,
            ];
        }
        $elementDifference = array_diff(config("app.all_lang"), config("app.alternative_lang"));
        $arrTranslate[] = [
            "href" => $boneUrl["scheme"]."://".$boneUrl["host"].$path,
            "hreflang" => isset($elementDifference[0]) ? $elementDifference[0] : "en",
        ];

        return $arrTranslate;
    }

}
