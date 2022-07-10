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
use App\Model\RespondVacancy;
use App\Model\UserSaveVacancy;
use App\Model\UserHideVacancy;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use Illuminate\Support\Facades\Auth;


class VacancyController extends BaseController {
    use GeneralVacancyResumeTraite;

    protected $repository;
    protected $count_pagination = 0;

    public function __construct() {
        parent::__construct();
        $this->repository = new VacancyRepository();
        $this->count_pagination = 5;
    }

    public function index(IndexVacancyRequest $request)
    {
        $my_user = Auth::user();
        $ids_respond = [];
        // 1
        $settings = $this->getSettingsDocumentsAndCountries();
        // 2 фильтр выборки
        $vacancies = $this->repository->initialDataForSampling($request);
        // 3 не показывать мои вакансии
        if(!is_null($my_user)){
            $vacancies = $vacancies->where('user_id', '!=', $my_user->id);
            // 4 не показывать мною скрытые вакансии
            $idHide = UserHideVacancy::where('user_id',$my_user->id)->get()->pluck('vacancy_id');
            $vacancies = $vacancies->whereNotIn('id', $idHide);
        }

        $vacancies = $vacancies
            ->with('position','company.image','id_saved_vacancies','id_hide_vacancies','country','region','city')
            ->paginate($this->count_pagination);

        // 4 выбрать id вакансий на которые я уже откликнулся (отображение что откликнулся)
        $idVacancies = $vacancies->pluck('id');
        if(!is_null($my_user)){
            $ids_respond = RespondVacancy::where('user_resume_id',$my_user->id)
                ->whereIn('vacancy_id',$idVacancies)->get()->pluck('vacancy_id');
        }

        return view('search_vacancies', compact('settings', 'vacancies', 'ids_respond'));
    }

    /**
     * показ указанной вакансии
     * откликнуться, предложив резюме
     * @param  Vacancy  $vacancy
     * @param  ShowVacancyRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Vacancy $vacancy, ShowVacancyRequest $request)
    {
        $arrData = $this->repository->show($request);
        $settings = $this->getSettingsDocumentsAndCountries();
        $settings['contact_information'] = config('site.contacts.contact_information');
        $arrData['respond']['settings'] = $settings;

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
        $vacancies = Vacancy::where('user_id', Auth::user()->id)
            ->with('position','country','region','city')
            ->withCount('respond')
            ->orderBy('created_at', 'desc')
            ->get();

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
        $vacancies = UserSaveVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image','vacancy.country','vacancy.region','vacancy.city')
            ->get();

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
        $vacancies = UserHideVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image','vacancy.country','vacancy.region','vacancy.city')
            ->get();

        return view('vacancies.hidden_vacancies', compact('settings','vacancies'));
    }

}
