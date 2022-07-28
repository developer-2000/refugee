<?php
namespace App\Http\Traits;

use App\Services\MetaService;
use Butschster\Head\Facades\Meta;

trait MetaTrait
{

    /**
     * страница index сайта
     */
    private function setMetaIndexPage(){
        $this->metaTags(new MetaService(), [
            "title" => config('app.name', "").__('meta_tags.index_page.title'),
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
        elseif ( !is_null($boolArr["now_country"]) && (is_null($boolArr["now_region"]) || is_null($boolArr["now_city"])) ){
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
                "title" => __('meta_tags.vacancies_city.title', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"] ]).config('app.name', ""),
                "description" =>  __('meta_tags.vacancies_city.description', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"], ]).config('app.name', ""),
                "keywords" => __('meta_tags.vacancies_city.keywords', [ 'city' => $city, 'country' => $boolArr["now_country"]["translate"], ]),
                "canonical" => url()->current(),
            ]);

//<title>Work in Odesa | Jobs in Odesa | Work.ua</title>
//<meta name="Keywords" content="jobs in kyiv, work, jobs in ukraine, jobs, resumes, search jobs, looking for a job, employers, recruiting, work ua">
//<meta name="Description" content="Work.ua has 1860 jobs in Odesa. Now finding a job in Odesa is easy. Search using job titles, categories, and new job emails. Find work in Odesa on Work.ua.">
//
//<title>Работа в Одессе. Вакансии в Одессе — Work.ua</title>
//<meta name="Keywords" content="работа в киеве, работа, работа в украине, вакансии, резюме, кандидаты, поиск работы, ищу работу, работодатели, подбор персонала, work ua, ворк юа">
//<meta name="Description" content="1861 вакансия в Одессе на Work.ua. Найти работу в Одессе теперь просто. Поиск вакансий по запросу, категориям, рассылка новых вакансий. Работа в Одессе на Work.ua найдется.">

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
            "title" => __('meta_tags.show_vacancy.title', [ 'title' => $vacancy["position"]["title"], 'salary' => $salary, 'company' => $vacancy["company"]["title"], 'address' => $address]).config('app.name', ""),
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
        elseif ( !is_null($boolArr["now_country"]) && (is_null($boolArr["now_region"]) || is_null($boolArr["now_city"])) ){
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
                "title" => __('meta_tags.resumes_city.title', ["city"=>$city ]).config('app.name', ""),
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
     * формирует мета теги страницы
     * @param  MetaService  $meta
     * @param $data
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
