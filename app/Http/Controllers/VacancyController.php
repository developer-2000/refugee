<?php
namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\DeleteVacancyRequest;
use App\Http\Requests\Vacancy\DuplicateVacancyRequest;
use App\Http\Requests\Vacancy\EditVacancyRequest;
use App\Http\Requests\Vacancy\SaveVacancyRequest;
use App\Http\Requests\Vacancy\SearchVacancyRequest;
use App\Http\Requests\Vacancy\StoreVacancyRequest;
use App\Http\Requests\Vacancy\UpdateVacancyRequest;
use App\Http\Requests\Vacancy\UpVacancyStatusRequest;
use App\Model\MakeGeographyDb;
use App\Model\Position;
use App\Model\User;
use App\Model\UserSaveVacancy;
use App\Model\UserShowVacancy;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacancyController extends BaseController {

    protected $repository;

    public function __construct() {
        $this->repository = new VacancyRepository();
    }

    public function index()
    {
        $settings = $this->getSettingsVacanciesAndCountries();
        $vacancies = Vacancy::with('position','employer.logo','id_saved_vacancies','id_not_shown_vacancies')
            ->paginate(10)->toArray();

        return view('index', compact('settings', 'vacancies'));
    }

    /**
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
     * delete vacancy
     * @param  DeleteVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteVacancyRequest $request)
    {
        $vacancy = Vacancy::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if(!$vacancy){
            return $this->getErrorResponse('Not found!');
        }

        $count_position = Vacancy::where('position_id', $vacancy->position_id)->count();

        $vacancy->delete();
        if($count_position === 1){
            Position::where('id', $vacancy->position_id)->delete();
        }

        return $this->getResponse($count_position);
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

        $settings = config('site.settings_vacancy');
        if($objCountries = MakeGeographyDb::find(1)->first()->pluck('country')){
            $settings['obj_countries'] = $objCountries[0]['EN'];
        }

        return view('vacancies/create_vacancy', compact('vacancy','settings'));
    }

    /**
     * изменить вакансию
     * @param  UpdateVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVacancyRequest $request)
    {
        // моя вакансия
        $vacancy = Vacancy::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->with('position')
            ->first();
        if(!$vacancy){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }

        $update = $this->repository->updateVacancy($request);

        return $this->getResponse();
    }

    /**
     * найти должность по первым символам
     * @param  SearchVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPosition(SearchVacancyRequest $request)
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
            ->with('vacancies.position')
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
        $vacancy = Vacancy::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if(!$vacancy){
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
     * показ вакансий в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookmarkVacancies()
    {
        $settings = $this->getSettingsVacanciesAndCountries();
        $vacancies = UserSaveVacancy::where('user_id', Auth::user()->id)
            ->with('vacancy.position','vacancy.employer.logo')
            ->get();

        return view('vacancies.bookmark_vacancies', compact('settings','vacancies'));
    }

    /**
     * скрыть выбранную вакансию в поиске
     * @param  SaveVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hideVacancyInSearch(SaveVacancyRequest $request)
    {
        $this->switchActionVacancy($request, new UserShowVacancy());
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
        return $settings;
    }




//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Model\Vacancy  $vacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Vacancy $vacancy)
//    {
//        //
//    }



}
