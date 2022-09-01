<?php
namespace App\Http\Traits;

use App\Services\MetaService;
use Butschster\Head\Facades\Meta;
use Butschster\Head\Packages\Entities\OpenGraphPackage;

trait MetaTrait
{

    /**
     * страница index сайта
     */
    private function setMetaIndexPage(){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.index_page.title').config('app.name', ""),
            "description" => config('app.name', "").__('meta_tags.index_page.description'),
            "keywords" => __('meta_tags.index_page.keywords'),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страницы поиска вакансий
     * @param $boolArr
     */
    private function setMetaAllVacanciesPage($boolArr){
        // 1 все вакансии
        if( is_null($boolArr["now_country"]) ){
            $this->metaTags(new MetaService(), [
                "title" => __('meta_tags.all_vacancies.title').config('app.name', ""),
                "description" => __('meta_tags.all_vacancies.description'),
                "keywords" => __('meta_tags.all_vacancies.keywords'),
                "canonical" => url()->current(),
            ]);
        }
        // 2 вакансии страны
        elseif ( !is_null($boolArr["now_country"]) && (is_null($boolArr["now_region"]) && is_null($boolArr["now_city"])) ){
            $this->metaTags(new MetaService(), [
                "title" => __('meta_tags.vacancies_country.title', ['name' => $boolArr["now_country"]["translate"]])." - ".config('app.name', ""),
                "description" =>__('meta_tags.vacancies_country.description', ['name' => $boolArr["now_country"]["translate"]]).config('app.name', ""),
                "keywords" => __('meta_tags.vacancies_country.keywords', ['name' => $boolArr["now_country"]["translate"]]),
                "canonical" => url()->current(),
            ]);
        }
        // 3 вакансии региона или города
        elseif ( !is_null($boolArr["now_region"]) || !is_null($boolArr["now_city"]) ){
            $city = !is_null($boolArr["now_city"]) ? $boolArr["now_city"]["translate"] : $boolArr["now_region"]["translate"];

            $this->metaTags(new MetaService(), [
                "title" => __('meta_tags.vacancies_city.title', [
                    'city' => $city,
                        'country' => $boolArr["now_country"]["translate"]
                    ]).config('app.name', ""),
                "description" =>  __('meta_tags.vacancies_city.description', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"], ]).config('app.name', ""),
                "keywords" => __('meta_tags.vacancies_city.keywords', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"], ]),
                "canonical" => url()->current(),
            ]);
        }
    }

    /**
     * страница указаной вакансии
     * @param $vacancy
     */
    private function setMetaShowVacancyPage($vacancy){
        $salary = ($vacancy["salary"]["radio_name"] == "range") ?
            ($vacancy["salary"]["inputs"]["from"]." - ".$vacancy["salary"]["inputs"]["to"]) :
            (($vacancy["salary"]["radio_name"] == "single_value") ? $vacancy["salary"]["inputs"]["salary_sum"] : "");
        $address = isset($vacancy["address"]["city"]) ? $vacancy["address"]["city"]["translate"] : $vacancy["address"]["region"]["translate"];

        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.show_vacancy.title', [
                'title' => $vacancy["position"]["title"], 'salary' => $salary
                ]).config('app.name', ""),
            "description" => __('meta_tags.show_vacancy.description', [ 'company' => $vacancy["company"]["title"], 'title' => $vacancy["position"]["title"], 'salary' => $salary, 'address' => $address,]).config('app.name', ""),
            "keywords" => __('meta_tags.show_vacancy.keywords', [ 'address' => $address]),
            "canonical" => url()->current(),
        ]);

    }

    /**
     * страницы поиска вакансий
     * @param $boolArr
     */
    private function setMetaAllResumesPage($boolArr){
        // 1 все резюме
        if( is_null($boolArr["now_country"]) ){
            $this->metaTags(new MetaService(), [
                "title" => __('meta_tags.all_resumes.title').config('app.name', ""),
                "description" =>  config('app.name', "").__('meta_tags.all_resumes.description'),
                "keywords" => __('meta_tags.all_resumes.keywords'),
                "canonical" => url()->current(),
            ]);
        }
        // 2 резюме страны
        elseif ( !is_null($boolArr["now_country"]) && (is_null($boolArr["now_region"]) && is_null($boolArr["now_city"])) ){
            $this->metaTags(new MetaService(), [
                "title" => __('meta_tags.resumes_country.title', ["country"=>$boolArr["now_country"]["translate"]]).config('app.name', ""),
                "description" => __('meta_tags.resumes_country.description', [ "country"=>$boolArr["now_country"]["translate"], "site"=>config('app.name', "") ]),
                "keywords" => __('meta_tags.resumes_country.keywords', [ "country"=>$boolArr["now_country"]["translate"] ]),
                "canonical" => url()->current(),
            ]);
        }
        // 3 резюме региона или города
        elseif ( !is_null($boolArr["now_region"]) || !is_null($boolArr["now_city"]) ){
            $city = !is_null($boolArr["now_city"]) ? $boolArr["now_city"]["translate"] : $boolArr["now_region"]["translate"];
            $this->metaTags(new MetaService(), [
                "title" => __('meta_tags.resumes_city.title', [
                    "city"=>$city,
                        'country' => $boolArr["now_country"]["translate"]
                        ]).config('app.name', ""),
                "description" => __('meta_tags.resumes_city.description', ["city"=>$city, "country"=>$boolArr["now_country"]["translate"], ]).config('app.name', ""),
                "keywords" => __('meta_tags.resumes_city.keywords', ["city"=>$city, "country"=>$boolArr["now_country"]["translate"], ]),
                "canonical" => url()->current(),
            ]);
        }
    }

    /**
     * страница указаной резюме
     * @param $resume
     */
    private function setMetaShowResumePage($resume){
        $address = isset($resume["address"]["city"]) ? $resume["address"]["city"]["translate"] : $resume["address"]["region"]["translate"];

        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.show_resume.title', [ "title"=>$resume["position"]["title"], "address"=>$address, ]).config('app.name', ""),
            "description" => __('meta_tags.show_resume.description', [ "title"=>$resume["position"]["title"], "address"=>$address, ]).config('app.name', ""),
            "keywords" => __('meta_tags.show_resume.keywords', [ "address"=>$address ]),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница указаной компании
     * @param $resume
     */
    private function setMetaShowCompanyPage($company){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.show_company.title', [ "company"=>$company["title"] ]).config('app.name', ""),
            "description" => __('meta_tags.show_company.description', [ "company"=>$company["title"] ]).config('app.name', ""),
            "keywords" =>  __('meta_tags.show_company.keywords', [ "company"=>$company["title"] ]),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница - о нас
     */
    private function setMetaAboutUsPage(){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.about_us.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.about_us.description', [ "app_name"=>config('app.name', "") ]),
            "keywords" => __('meta_tags.about_us.keywords'),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница связи
     */
    private function setMetaFeedbackPage(){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.feedback.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.feedback.description').config('app.name', ""),
            "keywords" => __('meta_tags.feedback.keywords'),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница пользовательское соглашение
     */
    private function setMetaTermsUsePage(){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.terms_use.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.terms_use.description').config('app.name', ""),
            "keywords" => __('meta_tags.terms_use.keywords'),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * страница cookie police
     */
    private function setMetaCookiePolicyPage(){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.cookie_policy.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.cookie_policy.description').config('app.name', ""),
            "keywords" => __('meta_tags.cookie_policy.keywords'),
            "canonical" => url()->current(),
        ]);
    }

    private function setMetaCharityPage(){
        $this->metaTags(new MetaService(), [
            "title" => __('meta_tags.charity.title')." | ".config('app.name', ""),
            "description" => __('meta_tags.charity.description').config('app.name', ""),
            "keywords" => __('meta_tags.charity.keywords'),
            "canonical" => url()->current(),
        ]);
    }

    /**
     * формирует мета теги страницы
     * @param  MetaService  $meta
     * @param $data
     * @param  null  $name_page
     */
    private function metaTags(MetaService $meta, $data){
        Meta::setTitle($data["title"])
            ->setDescription($data["description"])
            ->setCanonical($data["canonical"])
            ->setKeywords($data["keywords"]);

        foreach ($meta->getArrHreflang() as $key => $arr) {
            Meta::setHrefLang($arr["hreflang"], $arr["href"]);
        }
    }

}
