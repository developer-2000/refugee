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
use App\Http\Traits\MetaTrait;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\UserSaveVacancy;
use App\Model\UserHideVacancy;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use App\Services\LocalizationService;
use App\Services\MetaService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VacancyController extends BaseController {
    use GeneralVacancyResumeTraite, MetaTrait;

    protected $repository;
    protected $count_pagination = 0;

    public function __construct() {
        parent::__construct();
        $this->repository = new VacancyRepository();
        $this->count_pagination = 20;
    }

    public function index(IndexVacancyRequest $request, $country = null, $city = null) {
        $my_user = Auth::user();
        $ids_respond = [];

        // 1 все не мои вакансии
        $vacancies = $this->repository->index($request, $this->count_pagination);
        // 2 выбрать id вакансий на которые я откликнулся или мне предложили (отображение что откликнулся)
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

        // 3 набор данных по геолокации
        $respond = $this->repository->indexRespond($request);
        $respond['vacancies'] = $vacancies;
        $respond['ids_respond'] = $ids_respond;

        $this->setMetaAllVacanciesPage($respond);

        return view('search_vacancies', compact('respond'));
    }

    /**
     * показ указанной вакансии
     * откликнуться, предложив резюме
     * @param  Vacancy  $vacancy
     * @param  ShowVacancyRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ShowVacancyRequest $request)
    {
        $arrData = $this->repository->show($request);
        $settings = $this->getSettingsDocumentsAndCountries();
        $settings['contact_information'] = config('site.contacts.contact_information');
        $arrData['respond']['settings'] = $settings;

        $this->setMetaShowVacancyPage($arrData["respond"]["vacancy"]);

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
    public function update(UpdateVacancyRequest $request)
    {
        if(!$vacancy = $this->checkMyDocument( $request, new Vacancy() )){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }
        $update = $this->repository->updateVacancy($request, $vacancy->position_id);

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
