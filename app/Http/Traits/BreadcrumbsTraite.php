<?php
namespace App\Http\Traits;

use App\Model\Test;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

trait BreadcrumbsTraite {
    use ArrayMethodsTraite;

    protected $elementsBread = [];

    public function setElementsBread()
    {
        $this->elementsBread[] = $this->makeBackUrlLink();
    }

    /**
     * масив с обратными url страниц
     * @return mixed
     */
    public function getElementsBread()
    {
        return $this->elementsBread;
    }

    private function makeBackUrlLink()
    {
        $last_url = URL::previous();                // прошлый url
        $query = explode("?", $last_url);  // составные url до и после ?
        $query[0] = str_replace('//', '/', $query[0]);
        $array = explode("/", $query[0]);  // масив url составных
        // масив двух последних составных url
        $company = $this->PenultimateElementArray($array);
        $response = [];

        // VACANCY
        // из Поиска вакансий на вакансию
        if($this->LastElementArray($array)[0] == 'vacancy'){
            // добавить query url
            $may_be = isset($query[1]) ? "?$query[1]" : "";
            $response[] = [
                'name'=>'vacancy',
                'url'=>App::getLocale()."/vacancy$may_be",
            ];
        }
        // из Сохраненных на вакансию
        elseif($this->LastElementArray($array)[0] == 'bookmark-vacancies'){
            $response[] = [
                'name'=>'bookmark_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/bookmark-vacancies",
            ];
        }
        // из Скрытых на вакансию
        elseif($this->LastElementArray($array)[0] == 'hidden-vacancies'){
            $response[] = [
                'name'=>'hidden_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/hidden-vacancies",
            ];
        }
        // из Моих вакансий на вакансию
        elseif($this->LastElementArray($array)[0] == 'my-vacancies'){
            $response[] = [
                'name'=>'my_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/my-vacancies",
            ];
        }
        // из Компании на вакансию
        elseif($company[0] == 'company'){
            $response[] = [
                'name'=>'company',
                'url'=>App::getLocale()."/company/$company[1]",
            ];
        }

        // RESUME
        // из Поиска резюме на резюме
        if($this->LastElementArray($array)[0] == 'resume'){
            // добавить query url
            $may_be = isset($query[1]) ? "?$query[1]" : "";
            $response[] = [
                'name'=>'resume',
                'url'=>App::getLocale()."/resume$may_be",
            ];
        }
        // из Сохраненных на резюме
        elseif($this->LastElementArray($array)[0] == 'bookmark-resumes'){
            $response[] = [
                'name'=>'bookmark_resumes',
                'url'=>App::getLocale()."/private-office/resume/bookmark-resumes",
            ];
        }
        // из Скрытых на резюме
        elseif($this->LastElementArray($array)[0] == 'hidden-resumes'){
            $response[] = [
                'name'=>'hidden_resumes',
                'url'=>App::getLocale()."/private-office/resume/hidden-resumes",
            ];
        }
        // при переходе с моих резюме на резюме
        elseif($this->LastElementArray($array)[0] == 'my-resumes'){
            $response[] = [
                'name'=>'my_resumes',
                'url'=>App::getLocale()."/private-office/resume/my-resumes",
            ];
        }

        // по умолчанию на главную
        if(!count($response)){
            $response[] = [
                'name'=>'index',
                'url'=>App::getLocale()."/"
            ];
        }
        // вторая ссылка в breadcrumbs
        $response[] = [
            'name'=>'cabinet',
            'url'=>App::getLocale()."/private-office",
        ];

        return $response;
    }

}
