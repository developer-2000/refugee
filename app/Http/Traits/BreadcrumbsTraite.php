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

    protected function makeBackUrlLink()
    {
        $last_url = URL::previous();                // прошлый url
        $query = explode("?", $last_url);  // составные url до и после ?
        $query[0] = str_replace('//', '/', $query[0]);
        $array = explode("/", $query[0]);  // масив url составных
        // масив двух последних составных url
        $company = $this->PenultimateElementArray($array);
        $response = [];

        // VACANCY
        // при переходе из поиска вакансий на вакансию
        if($this->LastElementArray($array)[0] == 'vacancy'){
            // добавить query url
            $may_be = isset($query[1]) ? "?$query[1]" : "";
            $response[] = [
                'name'=>'vacancy',
                'url'=>App::getLocale()."/vacancy$may_be",
            ];
        }
        // при переходе с сохраненных на вакансию
        elseif($this->LastElementArray($array)[0] == 'bookmark-vacancies'){
            $response[] = [
                'name'=>'bookmark_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/bookmark-vacancies",
            ];
        }
        // при переходе с скрытых на вакансию
        elseif($this->LastElementArray($array)[0] == 'hidden-vacancies'){
            $response[] = [
                'name'=>'hidden_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/hidden-vacancies",
            ];
        }
        // при переходе с моих вакансий на вакансию
        elseif($this->LastElementArray($array)[0] == 'my-vacancies'){
            $response[] = [
                'name'=>'my_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/my-vacancies",
            ];
        }
        // при переходе с компании на вакансию
        elseif($company[0] == 'company'){
            $response[] = [
                'name'=>'company',
                'url'=>App::getLocale()."/company/$company[1]",
            ];
        }

        // RESUME
        // при переходе с моих резюме на резюме
        elseif($this->LastElementArray($array)[0] == 'my-resumes'){
            $response[] = [
                'name'=>'my-resumes',
                'url'=>App::getLocale()."/private-office/resume/my-resumes",
            ];
        }



        // по умолчанию
        if(!count($response)){
            $response[] = ['name'=>null];
        }
        else{
            $response[] = [
                'name'=>'cabinet',
                'url'=>App::getLocale()."/private-office",
            ];
        }

        return $response;
    }

}
