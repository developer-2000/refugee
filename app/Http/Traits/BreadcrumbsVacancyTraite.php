<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

trait BreadcrumbsVacancyTraite {
    use FunctionsTraite;

    protected $elementsBread = [];

    public function setElementsBread()
    {
        $this->elementsBread[] = $this->makeBackUrlLink();
    }

    protected function makeBackUrlLink()
    {
        $last_page = URL::previous();
        $array = explode("/", $last_page);

        if($this->LastElementArray($array)[0] == 'vacancy'){
            return [
                'name'=>'vacancy',
                'url'=>App::getLocale()."/vacancy",
            ];
        }
        elseif($this->LastElementArray($array)[0] == 'bookmark-vacancies'){
            return [
                'name'=>'bookmark_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/bookmark-vacancies",
            ];
        }
        elseif($this->LastElementArray($array)[0] == 'hidden-vacancies'){
            return [
                'name'=>'hidden_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/hidden-vacancies",
            ];
        }
        elseif($this->LastElementArray($array)[0] == 'my-vacancies'){
            return [
                'name'=>'my_vacancies',
                'url'=>App::getLocale()."/private-office/vacancy/my-vacancies",
            ];
        }

        return ['name'=>null];
    }

    /**
     * масив с обратными url страниц
     * @return mixed
     */
    public function getElementsBread()
    {
        return $this->elementsBread;
    }

}
