<?php
namespace App\Repositories;

use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Http\Traits\Geography\GeographyForShowInterfaceTraite;
use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\Offer;
use App\Model\Position;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\UserHideVacancy;
use App\Model\UserResume;
use App\Model\UserSaveVacancy;
use App\Model\Vacancy as Model;
use App\Services\LocalizationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VacancyRepository extends CoreRepository {
    use GeneralVacancyResumeTraite, GeographyWorkSeparateEntryTraite, GeographyForShowInterfaceTraite;

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->settings = (object) config('site.settings_vacancy');
    }

    public function storeVacancy($request){
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );
        $arr = $this->makeArrayVacancy($request, $position);
        $arr['user_id'] = Auth::user()->id;
        $arr['alias'] = sha1(time());
        return $this->model->create($arr);
    }

    public function updateVacancy($request, $position_id){
        // удалить старое название, если оно не будет никем использоватся
        $this->deleteUnwantedTitle($request, $position_id);
        // создать или взять имеющееся название
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->update($this->makeArrayVacancy($request, $position));
    }

    public function index($request, $count_pagination){
        $my_user = Auth::user();

        // 1 фильтр выборки
        $vacancies = $this->initialDataForSampling($request);

        if(!is_null($my_user)){
            // не показывать мои вакансии
            $vacancies = $vacancies->where('user_id', '!=', $my_user->id);
            // не показывать мною скрытые вакансии
            $idHide = UserHideVacancy::where('user_id',$my_user->id)->get()->pluck('vacancy_id');
            $vacancies = $vacancies->whereNotIn('id', $idHide);
        }

        $vacancies = $vacancies
            ->with('position','company.image','id_saved_vacancies','id_hide_vacancies','country','region','city')
            ->paginate($count_pagination);

        // 3 address
        foreach ($vacancies as $key => $vacancy){
            $vacancy = $this->addPropertiesToCollection($vacancy);
            $vacancy = collect($vacancy);
            $vacancies[$key] = $vacancy->except(['city','region','country']);
        }

        return $vacancies;
    }

    public function indexRespond($request){
        $all_regions = (new LocalizationService())->getRegions(App::getLocale());
        // в базе нет городов без регионов
        $all_cities = (new LocalizationService())->getCities(App::getLocale());
        $respond = $this->getSettingsDocumentsAndCountries();

        // текущая страна
        $respond['now_country'] = null;
        // регионы текущей страны
        $respond['regions_country'] = null;
        $respond['now_region'] = null;
        $respond['cities_region'] = null;
        $respond['now_city'] = null;

        // 1 обьекты текущей страны и регионов страны
        if(!is_null($request->country)){
            // 1 найти текущую страну
            $now_country = collect($respond['obj_countries'])->filter(function ($arr, $key) use ($request) {
                return $arr['original_index'] == $request->country;
            })->first();
            $respond['now_country'] = $now_country;

            // 2 (в базе нет стран без регионов)
            $regions_country = $this->filterCollection($all_regions, 'prefix', mb_strtolower($respond['now_country']['prefix']), mb_strtolower($respond['now_country']["prefix"]))
                ->all();
            $respond['regions_country'] = $regions_country;
        }

        // 2 определить что на месте city (может быть регион в котором нет городов)
        if(!is_null($request->city)){

            $city = $this->filterCollection($all_cities, 'original_index', $request->city, mb_strtolower($respond['now_country']["prefix"]))
                ->first();
            $respond['now_city'] = $city;

            // 2.2.1 если $request->city - город
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

            if(isset($region)){
                if(isset($region)){
                    $cities_region = $this->filterCollection($all_cities, 'code_region', $region["code_region"], mb_strtolower($respond['now_country']["prefix"]))
                        ->all();
                    $respond['cities_region'] = $cities_region;
                }
            }
        }

        return $respond;
    }

    public function show($request){
        $my_user = Auth::user();
        $respond_data['arr_resume'] = [];
        $owner_vacancy = null;
        $informationRepository = new ContactInformationRepository();
        $modalOffer = new Offer();

        // 1 смотреть вакансию
        $vacancy = $this->model->where('alias', $request->alias)
            ->with(
                'position',
                'contact.avatar',
                'contact.position',
                'company.image',
                'id_saved_vacancies',
                'id_hide_vacancies',
                'country','region','city'
            )
            ->first();

        // 1 address
        $vacancy = $this->addPropertiesToCollection($vacancy);

        // 2 контакт лист хозяина документа
        $contact_list = $informationRepository->fillContactList($vacancy->contact, $vacancy->user_id);
        if(!is_null($my_user)){

            // я подписывался на вакансию
            $respond = (new RespondVacancy())->selectByVacancyUserResumeId($request->vacancy_id, $my_user->id);
            if(is_null($respond)){
                // соискатель предложил вакансию на мое резюме
                $respond = (new RespondResume())->selectByVacancyUserResumeId($request->vacancy_id, $my_user->id);
            }

            // установлен ли чат ?
            if( $respond ){
                // 3,1 имя хозяина документа
                $owner_vacancy = new \stdClass();
                $owner_vacancy->contact = new \stdClass();
                $owner_vacancy->contact->name = $vacancy->contact->name;

                // 3,2 alias нашего чата;
                $owner_vacancy->offer = null;

                if($offer = $modalOffer->selectChatByUserId($vacancy->user_id, $my_user->id)){
                    $owner_vacancy->offer = new \stdClass();
                    $owner_vacancy->offer->alias = $offer->alias;
                }
            }
            else{
                // 3,1 все мои резюме для отклика
                $respond_data['arr_resume'] = UserResume::where('user_id', $my_user->id)
                    ->with('position')->get();
            }
        }

        $vacancy = collect($vacancy);
        $vacancy = $vacancy->except(['city', 'region', 'country']);

        return [
            'respond' => [
                'in_table' => $modalOffer->inTable,
                'vacancy' => $vacancy,
                'respond_data' => $respond_data,
                'owner_vacancy' => $owner_vacancy,
                'contact_list' => $contact_list,
            ]
        ];
    }

    public function getBookmarkVacancies(){
        $vacancies = UserSaveVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image','vacancy.country','vacancy.region','vacancy.city')
            ->get();

        // address
        foreach ($vacancies as $key => $vacancy){
            $vacancy->vacancy = $this->addPropertiesToCollection($vacancy->vacancy);
        }

        return $vacancies;
    }

    public function getHiddenVacancies(){
        $vacancies = UserHideVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image','vacancy.country','vacancy.region','vacancy.city')
            ->get();

        // address
        foreach ($vacancies as $key => $vacancy){
            $vacancy->vacancy = $this->addPropertiesToCollection($vacancy->vacancy);
        }

        return $vacancies;
    }

    public function myVacancies(){
        $vacancies = $this->model->where('user_id', Auth::user()->id)
            ->with('position','country','region','city')
            ->withCount('respond')
            ->orderBy('created_at', 'desc')
            ->get();

        // address
        foreach ($vacancies as $key => $vacancy){
            $vacancy = $this->addPropertiesToCollection($vacancy);
            $vacancy = collect($vacancy);
            $vacancies[$key] = $vacancy->except(['city','region','country']);
        }

        return $vacancies;
    }

    /**
     * вернет мои вакансии
     * @return mixed
     */
    public function getMyVacancies($user){
        if(!is_null($user)){
            return $this->model->where('user_id',$user->id)
                ->get();
        }
        return null;
    }

    private function makeArrayVacancy($request, $position){
        return [
            'position_id'=>$position->id,
            'categories'=>$request->categories,
            'languages'=>$request->languages,
            'country_id' => $this->createSpecifiedLocationRecord($request, 'country', 0),
            'region_id' => $this->createSpecifiedLocationRecord($request, 'region', 1),
            'city_id' => $this->createSpecifiedLocationRecord($request, 'city', 2),
            'rest_address'=>$request->rest_address,
            'vacancy_suitable'=>[
                'radio_name'=>$request->vacancy_suitable,
                'inputs'=>[
                    'from'=>$request->suitable_from,
                    'to'=>$request->suitable_to,
                ],
                'comment'=>$request->suitable_commentary,
            ],
            'type_employment'=>$request->type_employment,
            'salary'=>[
                'radio_name'=>$request->salary_but,
                'inputs'=>[
                    'from'=>$request->from,
                    'to'=>$request->to,
                    'salary_sum'=>$request->salary_sum,
                ],
                'comment'=>$request->salary_comment,
            ],
            'experience'=>$request->experience,
            'education'=>$request->education,
            'text_description'=>$request->text_description,
            'text_working'=>$request->text_working,
            'text_responsibilities'=>$request->text_responsibilities,
            'how_respond'=>$request->how_respond,
            'job_posting'=>[
                'status_name'=> $this->settings->job_status[$request->job_posting],
                'create_time'=>now(),
            ],
        ];
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
