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
use App\Model\MakeGeographyDb;
use App\Model\Position;
use App\Model\User;
use App\Model\UserSaveVacancy;
use App\Model\UserHideVacancy;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use Illuminate\Support\Facades\Auth;

class VacancyController extends BaseController {

    protected $repository;

    public function __construct() {
        parent::__construct();

        $this->repository = new VacancyRepository();
    }

    public function index(IndexVacancyRequest $request)
    {
        $settings = $this->getSettingsVacanciesAndCountries();
        $vacancies = $this->repository->initialDataForSampling($request)
            ->with('position','company.image','id_saved_vacancies','id_not_shown_vacancies')
            ->paginate(5);

        return view('index', compact('settings', 'vacancies'));
    }

    /**
     * показ указанной вакансии
     * @param  Vacancy  $vacancy
     * @param  ShowVacancyRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Vacancy $vacancy, ShowVacancyRequest $request)
    {
        $settings = $this->getSettingsVacanciesAndCountries();
        $vacancy = Vacancy::where('id', $request->vacancy_id)
            ->with('position','company.image','id_saved_vacancies','id_not_shown_vacancies')
            ->first();
        return view('vacancies.show_vacancy', compact('settings','vacancy'));
    }

    /**
     * форма для создания
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $settings = $this->getSettingsVacanciesAndCountries();
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

        $settings = $this->getSettingsVacanciesAndCountries();

        return view('vacancies/create_vacancy', compact('vacancy','settings'));
    }

    /**
     * изменить вакансию
     * @param  UpdateVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVacancyRequest $request)
    {
        if(!$vacancy = $this->checkMyVacancy($request)){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }
        $update = $this->repository->updateVacancy($request, $vacancy->position_id);


        return $this->getResponse($update);
    }

    /**
     * delete vacancy
     * @param  DeleteVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteVacancyRequest $request)
    {
        if(!$vacancy = $this->checkMyVacancy($request)){
            return $this->getErrorResponse('Not found!');
        }
        // удалить старое название, если оно не будет никем использоватся
        Vacancy::deleteUnwantedVacancyTitle($request, $vacancy->position_id);
        $vacancy->delete();

        return $this->getResponse();
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

    /**
     * выбрать все свои вакансии
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myVacancies()
    {
        $settings = config('site.settings_vacancy');
        $user_data = User::where('id', Auth::user()->id)
            ->with('vacancies.position', 'vacancies.company.image')
            ->first();

        return view('vacancies/my_vacancies', compact('user_data','settings'));
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
        if(!$vacancy = $this->checkMyVacancy($request)){
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
     * добавить в закладки выбранную вакансию в поиске
     * @param  SaveVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookmarkVacancy(SaveVacancyRequest $request)
    {
        $this->switchActionVacancy($request, new UserSaveVacancy());
        return $this->getResponse();
    }

    /**
     * показ сохраненных вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookmarkVacancies()
    {
        $settings = $this->getSettingsVacanciesAndCountries();
        $vacancies = UserSaveVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image')
            ->get();

        return view('vacancies.bookmark_vacancies', compact('settings','vacancies'));
    }

    /**
     * показ скрытых вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hiddenVacancies()
    {
        $settings = $this->getSettingsVacanciesAndCountries();
        $vacancies = UserHideVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.company.image')
            ->get();

        return view('vacancies.hidden_vacancies', compact('settings','vacancies'));
    }

    /**
     * скрыть выбранную вакансию в поиске
     * @param  SaveVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hideVacancyInSearch(SaveVacancyRequest $request)
    {
        $this->switchActionVacancy($request, new UserHideVacancy());
        return $this->getResponse();
    }

    // ===
    // Private
    /**
     * переключение состояний выбранных вакансий (добавление в закладки и скрытие)
     * @param $request
     * @param $model
     */
    private function switchActionVacancy($request, $model){
        if($request->action == 1){
            $model::updateOrCreate(
                [
                    'user_id'=>Auth::user()->id,
                    'vacancy_id'=>$request->vacancy_id
                ]
            );
        }
        elseif($request->action == 0){
            $model::where('user_id', Auth::user()->id)
                ->where('vacancy_id',$request->vacancy_id)
                ->delete();
        }
    }

    /**
     * настройки вакансий и страны сайта
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getSettingsVacanciesAndCountries(){
        $settings = config('site.settings_vacancy');
        if($objCountries = MakeGeographyDb::where('id', 1)->select('country')->first()){
            $settings['obj_countries'] = $objCountries['country']['EN'];
        }
        $settings['categories'] = config('site.categories.categories');
        return $settings;
    }

    /**
     * проверка на мою вакансию
     * @param $request
     * @return mixed
     */
    private function checkMyVacancy($request){
        return Vacancy::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->first();
    }

}
