<?php
namespace App\Http\Traits;

use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Model\GeographyDb;
use App\Model\GeographyLocal;
use App\Model\Position;
use App\Services\LocalizationService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait GeneralVacancyResumeTraite {

    public function indexRespond($request){
        $all_regions = (new LocalizationService())->getRegions(App::getLocale());
        // в базе нет городов без регионов
        $all_cities = (new LocalizationService())->getCities(App::getLocale());
        $respond = $this->getSettingsDocumentsAndCountries();

        // 1 обьекты текущей страны и регионов страны
        if(!is_null($request->country)){

            // 1 найти текущую страну
            $now_country = collect($respond['obj_countries'])->filter(function ($arr, $key) use ($request) {
                return $arr['original_index'] == $request->country;
            })->first();
            // Not Found
            if(is_null($now_country)){
                return abort(404);
            }
            $respond['now_country'] = $now_country;

            // 2 (в базе нет стран без регионов)
            $regions_country = $this->filterCollection($all_regions, 'prefix', mb_strtolower($respond['now_country']['prefix']), mb_strtolower($respond['now_country']["prefix"]))
                ->all();
            $respond['regions_country'] = $regions_country;

            // 3 все города этой страны
            $respond['cities_country'] = collect($all_cities)->filter(function ($arr, $key) use ($now_country) {
                if(isset($arr["prefix"])){
                    return $arr["prefix"] == mb_strtolower($now_country['prefix']);
                }
                return false;
            });

        }

        // 2 определить что на месте city (может быть регион в котором нет городов)
        if(!is_null($request->city)){

            $city = $this->filterCollection($respond['cities_country'], 'original_index', $request->city, mb_strtolower($respond['now_country']["prefix"]))
                ->first();
            $respond['now_city'] = $city;

            // 2.1 если $request->city - город
            if(isset($city)){
                $region = $this->filterCollection($respond['regions_country'], 'code_region', $city["code_region"], mb_strtolower($respond['now_country']["prefix"]))
                    ->first();
                $respond['now_region'] = $region;
            }
            else{
                $region = $this->filterCollection($respond['regions_country'], 'original_index', $request->city, mb_strtolower($respond['now_country']["prefix"]))
                    ->first();
                $respond['now_region'] = $region;
            }

            // 2.2 если $request->city - region
            if(isset($region)){
                $cities_region = $this->filterCollection($respond['cities_country'], 'code_region', $region["code_region"], mb_strtolower($respond['now_country']["prefix"]))
                    ->all();
                $respond['cities_region'] = $cities_region;
            }

            // Not Found
            if( is_null($respond['now_city']) && is_null($respond['now_region']) ){
                return abort(404);
            }
        }

        return $respond;
    }

    /**
     * найти должность по первым символам
     * @param  SearchPositionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPosition(SearchPositionRequest $request)
    {
        $position = Position::where('active',1)
            ->where('title', 'like', $request->value.'%')
            ->get()
            ->pluck('title');
        return $this->getResponse(compact('position'));
    }

    public function initialDataForSampling($request){

        // поиск по заголовку с сортировкой
        $this->model = $this->searchByPositionWithSorting($request);
        $this->model = $this->categorySearch($request);
        $this->model = $this->salarySearch($request);
        $this->model = $this->languageSearch($request);
        $this->model = $this->employmentSearch($request);
        $this->model = $this->countrySearch($request);
        $this->model = $this->citySearch($request);
        $this->model = $this->experienceSearch($request);
        $this->model = $this->suitableSearch($request);
        $this->model = $this->educationSearch($request);

        return $this->model;
    }

    // Private
    /**
     * проверка на мое resume
     * @param $request
     * @param $model
     * @return mixed
     */
    private function checkMyDocument($request, $model){
        return $model::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->first();
    }

    /**
     * переключение состояний вакансий / резюме (добавление в закладки и скрытие)
     * @param $request
     * @param $model
     * @param $row
     */
    private function switchActionBookmark($request, $model, $row){
        if($request->action === 1){
            $model::updateOrCreate(
                [
                    'user_id'=>Auth::user()->id,
                    $row => $request->$row
                ]
            );
        }
        elseif($request->action === 0){
            $model::where('user_id', Auth::user()->id)
                ->where($row, $request->$row )
                ->delete();
        }
    }

    /**
     * настройки параметров вакансий / резюме и страны сайта
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getSettingsDocumentsAndCountries(){
        $settings = config('site.settings_vacancy');
        $settings = array_merge($settings, config('site.search_title_panel.collection_location'));
        $settings['start_search_page'] = config('site.search_title_panel.start_search_page');
        $settings['obj_countries'] = (new LocalizationService())->getCountries(App::getLocale());
        $settings['categories'] = config('site.categories.categories');

        return $settings;
    }

    /**
     * поиск по заголовку с сортировкой
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function searchByPositionWithSorting($request){
        if (isset($request->position)) {
            $stroke = '0';
            $arrPosition = explode(" ", $request->position);

            $coll = Position::when($arrPosition , function($query) use ($arrPosition) {
                $query->where(function ($query) use ($arrPosition) {
                    foreach($arrPosition as $word) {
                        $query->orWhere('title', 'like', '%' . $word . '%');
                    }
                });
            })->orderBy('title', 'asc')->get();

            if($coll->count()){
                $coll = $coll->pluck('id')->toArray();
                $stroke = implode(',',$coll);
            }

            $this->model = $this->model->whereIn('position_id', $coll)
                ->orderByRaw("field(position_id,{$stroke})", $coll);
        }

        return $this->model;
    }

    /**
     * поиск по префиксу страны
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function countrySearch($request){
        if (isset($request->country)) {
            // это имеющаяся запись страны в базе адресов
            $countryInDb = GeographyLocal::whereJsonContains('local->original_index', $request->country)
                ->where('type', 0)
                ->first();
            $country_id = is_null($countryInDb) ? null : $countryInDb->id;

            $this->model = $this->model->where('country_id', $country_id);
        }

        return $this->model;
    }

    /**
     * поиск по префиксу города
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function citySearch($request){
        if (isset($request->city)) {
            // это имеющаяся запись города в базе адресов
            $cityInDb = GeographyLocal::whereJsonContains('local->original_index', $request->city)
                ->where('type', 2)
                ->first();
            $city_id = is_null($cityInDb) ? null : $cityInDb->id;

            $this->model = $this->model->where('city_id', $city_id);
        }

        return $this->model;
    }

    /**
     * переберает ['7', '28', '63'] и выбирает каждый в котором есть хоть один
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function categorySearch($request){
        if (isset($request->categories)) {
            $categories = explode(",", $request->categories);

            $this->model = $this->model->when($categories , function($query) use ($categories) {
                $query->where(function ($query) use ($categories) {
                    foreach($categories as $id) {
                        $query->orWhereJsonContains('categories', intval($id));
                    }
                });
            });
        }

        return $this->model;
    }

    /**
     * зарплата вакансии
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function salarySearch($request){
        if (isset($request->salary)) {
            $arrStroke = explode(",", $request->salary);
            $arrStroke[0] = isset($arrStroke[0]) ? intval($arrStroke[0]) : 0;
            $arrStroke[1] = isset($arrStroke[1]) ? intval($arrStroke[1]) : 0;
            $arrStroke[2] = isset($arrStroke[2]) ? intval($arrStroke[2]) : 99999999;

            // поиск по - ЗП не указана
            if($arrStroke[0] === 1){
                $this->model = $this->model->where("salary->radio_name", 'dont_specify');
            }
            // поиск по интервал от и до либо фиксированная ЗП
            else{
                $this->model = $this->model->where(function($query) use ($arrStroke) {
                    // запрос 500-1000 (зайдет 200-600 или 500-1000)
                    $query->where(function ($query) use ($arrStroke) {
                        $query->where("salary->radio_name", 'range')
                            ->where("salary->inputs->from", "<=", $arrStroke[1])
                            ->where("salary->inputs->to", ">=", $arrStroke[1]);
                    })
                        // запрос 500-1000 (зайдет 600-999)
                        ->orWhere(function ($query) use ($arrStroke) {
                            $query->where("salary->radio_name", 'range')
                                ->where("salary->inputs->from", ">=", $arrStroke[1])
                                ->where("salary->inputs->to", "<=", $arrStroke[2]);
                        })
                        // запрос 500-1000 (зайдет 600-1100)
                        ->orWhere(function ($query) use ($arrStroke) {
                            $query->where("salary->radio_name", 'range')
                                ->where("salary->inputs->from", ">=", $arrStroke[1])
                                ->where("salary->inputs->from", "<=", $arrStroke[2]);
                        })
                        // запрос 500-1000 (зайдет от500 до1000)
                        ->orWhere(function ($query) use ($arrStroke) {
                            $query->where("salary->radio_name", 'single_value')
                                ->where("salary->inputs->salary_sum", ">=", $arrStroke[1])
                                ->where("salary->inputs->salary_sum", "<=", $arrStroke[2]);
                        });
                });
            }
        }

        return $this->model;
    }

    /**
     * переберает ['7', '28', '63'] и выбирает каждый в котором есть хоть один
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function languageSearch($request){
        if (isset($request->languages)) {
            $languages = explode(",", $request->languages);

            $this->model = $this->model->when($languages , function($query) use ($languages) {
                $query->where(function ($query) use ($languages) {
                    foreach($languages as $id) {
                        $query->orWhereJsonContains('languages', intval($id));
                    }
                });
            });
        }

        return $this->model;
    }

    /**
     * Вид занятости
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function employmentSearch($request){
        if (isset($request->employment)) {
            $this->model = $this->model->where('type_employment', $request->employment);
        }

        return $this->model;
    }

    /**
     * опыт работы
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function experienceSearch($request){
        if (isset($request->experience)) {
            $this->model = $this->model->where('experience', $request->experience);
        }

        return $this->model;
    }

    /**
     * выбрать возраст - диапозон больше меньше или статус - не важно
     * @param $request
     * @return \Illuminate\Contracts\Container\ContextualBindingBuilder|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function suitableSearch($request){
        if (isset($request->suitable)) {
            $arrSuitable = explode(",", $request->suitable);
            $arrSuitable[0] = isset($arrSuitable[0]) ? intval($arrSuitable[0]) : 0;
            $arrSuitable[1] = isset($arrSuitable[1]) ? intval($arrSuitable[1]) : 100;

            $url = $_SERVER['REQUEST_URI'];
            $vacancy = strrpos($url, "vacancy");
            $resume = strrpos($url, "resume");
            // поиск на странице поиска вакансий
            if ($vacancy !== false) {
                $this->model = $this->model->where(function($query) use ($arrSuitable) {
                    // запрос 18-60 (зайдет 10-20 или 18-60)
                    $query->where(function ($query) use ($arrSuitable) {
                        $query->where("vacancy_suitable->radio_name", "set_age")
                            ->where("vacancy_suitable->inputs->from", "<=", $arrSuitable[0])
                            ->where("vacancy_suitable->inputs->to", ">=", $arrSuitable[0]);
                    })
                        // запрос 18-60 (зайдет 19-59 или 18-60)
                        ->orWhere(function ($query) use ($arrSuitable) {
                            $query->where("vacancy_suitable->radio_name", "set_age")
                                ->where("vacancy_suitable->inputs->from", ">=", $arrSuitable[0])
                                ->where("vacancy_suitable->inputs->to", "<=", $arrSuitable[1]);
                        })
                        // запрос 18-60 (зайдет 20-70 или 18-60)
                        ->orWhere(function ($query) use ($arrSuitable) {
                            $query->where("vacancy_suitable->radio_name", "set_age")
                                ->where("vacancy_suitable->inputs->from", ">=", $arrSuitable[0])
                                ->where("vacancy_suitable->inputs->from", "<=", $arrSuitable[1]);
                        })->orWhere(function ($query) {
                            $query->where("vacancy_suitable->radio_name", "it_not_matter");
                        });
                });
            }
            // поиск на странице поиска резюме
            elseif ($resume !== false) {
                $from = Carbon::now()->subYears($arrSuitable[0])->year;
                $to = Carbon::now()->subYears($arrSuitable[1])->year;

                $this->model = $this->model->where(function($query) use ($from, $to) {
                    // запрос 18-60 (выдаст от18 до60 лет)
                    // $from = 2004 - $to = 1962
                    // человек 19 лет (data_birth - 2003-01-04)
                    $query->whereYear("data_birth", "<=", $from)
                        ->whereYear("data_birth", ">=", $to);
                });
            }
        }

        return $this->model;
    }

    /**
     * образование соискателя
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function educationSearch($request){
        if (isset($request->education)) {
            $this->model = $this->model->where('education', $request->education);
        }

        return $this->model;
    }

    private function filterCollection($array, $index, $value, $country_prefix){
        $respond = collect($array)->filter(function ($arr, $key) use ($value, $index, $country_prefix) {
            if(isset($arr[$index])){
                return $arr[$index] == $value && $arr["prefix"] == $country_prefix;
            }
            return false;
        });

        return $respond;
    }
}
