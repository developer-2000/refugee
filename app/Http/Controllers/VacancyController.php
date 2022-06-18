<?php
namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\DeleteVacancyRequest;
use App\Http\Requests\Vacancy\DuplicateVacancyRequest;
use App\Http\Requests\Vacancy\EditVacancyRequest;
use App\Http\Requests\Vacancy\IndexVacancyRequest;
use App\Http\Requests\Vacancy\SaveVacancyRequest;
use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Http\Requests\Vacancy\ShowVacancyRequest;
use App\Http\Requests\Vacancy\StoreVacancyRequest;
use App\Http\Requests\Vacancy\UpdateVacancyRequest;
use App\Http\Requests\Vacancy\UpVacancyStatusRequest;
use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Model\Image;
use App\Model\MakeGeographyDb;
use App\Model\Position;
use App\Model\RespondVacancy;
use App\Model\User;
use App\Model\UserResume;
use App\Model\UserSaveVacancy;
use App\Model\UserHideVacancy;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use Illuminate\Support\Facades\Auth;

class VacancyController extends BaseController {
    use GeneralVacancyResumeTraite;

    protected $repository;

    public function __construct() {
        parent::__construct();
        $this->repository = new VacancyRepository();
    }

    public function index(IndexVacancyRequest $request)
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $vacancies = $this->repository->initialDataForSampling($request)
            ->with('position','company.image','id_saved_vacancies','id_hide_vacancies')
            ->paginate(10);

        return view('search_vacancies', compact('settings', 'vacancies'));
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
        $owner_vacancy = null;
        $respond_data['arr_resume'] = [];
        $my_user = Auth::user();
        $settings = $this->getSettingsDocumentsAndCountries();

        // 1 смотреть вакансию
        $vacancy = Vacancy::where('id', $request->vacancy_id)
            ->with('position','company.image','id_saved_vacancies','id_hide_vacancies')
            ->first();

        if(!is_null($my_user)){
            // если я подписан на эту вакансию
            if( $respond = RespondVacancy::where('vacancy_id',$request->vacancy_id)
                ->where('user_resume_id',$my_user->id)->first()
            ){
                // 3 владелец вакансии для ссылки на него для общения
                $owner_vacancy = User::where('id',$vacancy->user_id)
                    ->with('contact')->first();
            }
            else{
                // 2 все мои резюме для отклика
                $respond_data['arr_resume'] = UserResume::where('user_id', $my_user->id)
                    ->with('position')->get();
            }
        }

        return view('vacancies.show_vacancy', compact('settings','vacancy', 'respond_data', 'owner_vacancy'));
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
            ->with('position')
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
            ->with('position')
            ->withCount('respond')
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
    public function bookmarkVacancy(SaveVacancyRequest $request)
    {
        $this->switchActionBookmark($request, new UserSaveVacancy(), 'vacancy_id');
        return $this->getResponse();
    }

    /**
     * показ сохраненных вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookmarkVacancies()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $vacancies = UserSaveVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image')
            ->get();

        return view('vacancies.bookmark_vacancies', compact('settings','vacancies'));
    }

    /**
     * скрыть из поиска выбранную вакансию
     * @param  SaveVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hideVacancy(SaveVacancyRequest $request)
    {
        $this->switchActionBookmark($request, new UserHideVacancy(), 'vacancy_id');
        return $this->getResponse();
    }

    /**
     * показ скрытых вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hiddenVacancies()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $vacancies = UserHideVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image')
            ->get();

        return view('vacancies.hidden_vacancies', compact('settings','vacancies'));
    }

}
