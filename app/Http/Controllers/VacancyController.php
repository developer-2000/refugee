<?php
namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\DuplicateVacancyRequest;
use App\Http\Requests\Vacancy\EditVacancyRequest;
use App\Http\Requests\Vacancy\IndexVacancyRequest;
use App\Http\Requests\Vacancy\SaveVacancyRequest;
use App\Http\Requests\Vacancy\ShowVacancyRequest;
use App\Http\Requests\Vacancy\StoreVacancyRequest;
use App\Http\Requests\Vacancy\UpdateVacancyRequest;
use App\Http\Requests\Vacancy\UpVacancyStatusRequest;
use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Http\Traits\SharingTraite;
use App\Jobs\Statistics\IncreaseNumberShowJob;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\UserSaveVacancy;
use App\Model\UserHideVacancy;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use App\Services\LanguageService;
use App\Services\MetaService;
use App\Services\StatisticVacanciesService;
use Butschster\Head\Facades\Meta;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Jorenvh\Share\ShareFacade;


class VacancyController extends BaseController {
    use GeneralVacancyResumeTraite, SharingTraite;

    protected $repository;
    protected $count_pagination = 0;

    public function __construct() {
        parent::__construct();
        $this->repository = new VacancyRepository();
        $this->count_pagination = 20;
        $service = new LanguageService();
        App::setLocale($service->selectLangFromUrl());
    }

    public function index(IndexVacancyRequest $request, $country = null, $city = null) {
        $metaService = new MetaService();
        $my_user = Auth::user();
        $ids_respond = [];

        // 1 выборка с пагинацией
        $vacancies = $this->repository->index($request, $this->count_pagination);

        // 2 выбрать id вакансий на которые я откликнулся или мне предложили (отображение в интерфейсе)
        $idVacancies = $vacancies->pluck('id');
        if(!is_null($my_user)){
            $ids_respond = RespondVacancy::where('user_resume_id',$my_user->id)
                ->whereIn('vacancy_id',$idVacancies)
                ->get()->pluck('vacancy_id')->toArray();
            $ids_respond2 = RespondResume::where('user_resume_id',$my_user->id)
                ->whereIn('vacancy_id',$idVacancies)
                ->get()->pluck('vacancy_id')->toArray();
            $ids_respond = array_merge($ids_respond, $ids_respond2);
        }

        // 3 увеличить кол-во показов
        IncreaseNumberShowJob::dispatch([
            "arr_id_vacancies"=>$idVacancies,
        ])->onQueue('default');

        // 4 набор данных по геолокации
        $respond = $this->repository->indexRespond($request);
        $respond['vacancies'] = $vacancies;
        $respond['ids_respond'] = $ids_respond;

        // 5 установить мета теги страницы
        $metaService->setMetaAllVacanciesPage($respond);

        // 6 установить  meta Open Graph
        $config = config('site.open_graph');
        $location_now = $metaService->checkLocation($respond);

        // 6.1 все вакансии
        if( $location_now === "all_documents" ){
            $config["title_page"] = __('meta_tags.all_vacancies.title');
            $config["description"] = __('meta_tags.all_vacancies.description');
        }
        // 6.2 вакансии страны
        elseif ( $location_now === "country" ){
            $config["title_page"] = __('meta_tags.vacancies_country.title', ['name' => $respond["now_country"]["translate"]]);
            $config["description"] = __('meta_tags.vacancies_city.open_graph');
        }
        // 6.3 вакансии региона или города
        elseif ( $location_now === "city" ){
            $city = !is_null($respond["now_city"]) ? $respond["now_city"]["translate"] : $respond["now_region"]["translate"];

            $config["title_page"] = __('meta_tags.vacancies_city.title', [
                'city' => $city,
                'country' => $respond["now_country"]["translate"]
            ]);
            $config["description"] = __('meta_tags.vacancies_city.open_graph');
        }

        $metaService->setOpenGraph($config);

        // 7 установить meta Twitter Card
        $metaService->setTwitterCard($config);

        // 8 вернуть ссылки Sharing соц-сетей
        $respond["social_share"] = $this->getLinksShare();

        return view('search_vacancies', compact('respond'));
    }

    /**
     * показ указанной вакансии
     * откликнуться, предложив резюме
     * @param  Vacancy  $vacancy
     * @param  ShowVacancyRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ShowVacancyRequest $request) {
        $metaService = new MetaService();
        $arrData = $this->repository->show($request);
        $settings = $this->getSettingsDocumentsAndCountries();
        $settings['contact_information'] = config('site.contacts.contact_information');
        $arrData['respond']['settings'] = $settings;
        $vacancy = $arrData["respond"]["vacancy"];

        // количество просмотров
        $statisticService = new StatisticVacanciesService();
        $statisticService->increaseNumberView($vacancy["id"]);

        // 1 установить мета теги страницы
        $metaService->setMetaShowVacancyPage($vacancy);

        // 2 установить meta Open Graph
        $config = config('site.open_graph');
        $salary = ($vacancy["salary"]["radio_name"] == "range") ?
            ($vacancy["salary"]["inputs"]["from"]." - ".$vacancy["salary"]["inputs"]["to"]) :
            (($vacancy["salary"]["radio_name"] == "single_value") ? $vacancy["salary"]["inputs"]["salary_sum"] : "");
        $user_name = $vacancy['contact']['full_name'];
        $address = isset($vacancy["address"]["city"]) ? $vacancy["address"]["city"]["translate"] : $vacancy["address"]["region"]["translate"];

        $config["title_page"] = __('meta_tags.show_vacancy.title', [
            'title' => $vacancy["position"]["title"],
            'salary' => $salary,
            'user_name' => $user_name,
        ]);
        $config["description"] = __(
            'meta_tags.show_vacancy.description',
            [
                'company' => $vacancy["company"]["title"],
                'title' => $vacancy["position"]["title"],
                'salary' => $salary, 'address' => $address,]
        );

        $metaService->setOpenGraph($config);

        // 3 установить meta Twitter Card
        $metaService->setTwitterCard($config);

        // 4 вернуть ссылки Sharing соц-сетей
        $arrData["respond"]["social_share"] = $this->getLinksShare();

        return view('vacancies.show_vacancy', $arrData);
    }

    /**
     * форма для создания
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $settings = $this->getSettingsDocumentsAndCountries();

        return view('vacancies/create_vacancy', compact('settings'));
    }

    /**
     * создать вакансию
     * @param  StoreVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreVacancyRequest $request)
    {
        $store = $this->repository->storeVacancy($request);

        return $this->getResponse();
    }

    /**
     * открыть для редактирования
     * @param  EditVacancyRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(EditVacancyRequest $request)
    {
        $vacancy = Vacancy::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->with('position','country','region','city')
            ->first();
        if(!$vacancy){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }

        $settings = $this->getSettingsDocumentsAndCountries();

        return view('vacancies/create_vacancy', compact('vacancy','settings'));
    }

    /**
     * изменить вакансию
     * @param  UpdateVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVacancyRequest $request) {
        if(!$vacancy = $this->checkMyDocument( $request, new Vacancy() )){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }
        $update = $this->repository->updateVacancy($request, $vacancy->position_id);

        // количество обновлений
        $statisticService = new StatisticVacanciesService();
        $statisticService->increaseNumberUpdate($request->id);

        return $this->getResponse($update);
    }

    /**
     * выбрать все свои вакансии для кабинета
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myVacancies()
    {
        $settings = config('site.settings_vacancy');
        $vacancies = $this->repository->myVacancies();

        return view('vacancies/my_vacancies', compact('vacancies','settings'));
    }

    /**
     * обновить статус вакансии
     * @param  UpVacancyStatusRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upVacancyStatus(UpVacancyStatusRequest $request)
    {
        $settings = (object) config('site.settings_vacancy');
        Vacancy::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->update([
                "published"=>0,
                'job_posting'=>[
                    'status_name'=>$settings->job_status[$request->index],
                    'create_time'=>now(),
                ],
            ]);

        return $this->getResponse();
    }

    /**
     * clone vacancy
     * @param  DuplicateVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateVacancy(DuplicateVacancyRequest $request)
    {
        if(!$vacancy = $this->checkMyDocument( $request, new Vacancy() )){
            return $this->getErrorResponse('Not found!');
        }

        $vacancy = collect($vacancy)->except(['id', 'updated_at', 'created_at'])->toArray();
        $vacancy['alias'] = sha1(time());
        $vacancy['published'] = 0;
        $vacancy['job_posting']['status_name'] = 'hidden';
        Vacancy::create($vacancy);

        return $this->getResponse();
    }

    /**
     * добавить в закладки выбранную вакансию
     * @param  SaveVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setBookmarkVacancy(SaveVacancyRequest $request)
    {
        $this->switchActionBookmark($request, new UserSaveVacancy(), 'vacancy_id');

        return $this->getResponse();
    }

    /**
     * показ сохраненных вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBookmarkVacancies()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $vacancies = $this->repository->getBookmarkVacancies();

        return view('vacancies.bookmark_vacancies', compact('settings','vacancies'));
    }

    /**
     * скрыть из поиска выбранную вакансию
     * @param  SaveVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setHideVacancy(SaveVacancyRequest $request)
    {
        $this->switchActionBookmark($request, new UserHideVacancy(), 'vacancy_id');

        return $this->getResponse();
    }

    /**
     * показ скрытых вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHiddenVacancies()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $vacancies = $this->repository->getHiddenVacancies();

        return view('vacancies.hidden_vacancies', compact('settings','vacancies'));
    }

}
