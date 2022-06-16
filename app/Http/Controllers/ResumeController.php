<?php

namespace App\Http\Controllers;

use App\Http\Requests\Resume\EditResumeRequest;
use App\Http\Requests\Resume\SaveResumeRequest;
use App\Http\Requests\Resume\ShowResumeRequest;
use App\Http\Requests\Resume\StoreResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Http\Requests\Resume\UpResumeStatusRequest;
use App\Http\Requests\Resume\DuplicateResumeRequest;
use App\Model\MakeGeographyDb;
use App\Model\RespondResume;
use App\Model\User;
use App\Model\UserHideResume;
use App\Model\UserResume;
use App\Model\UserSaveResume;
use App\Model\Vacancy;
use App\Repositories\ResumeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends BaseController {

    protected $repository;

    public function __construct() {
        parent::__construct();
        $this->repository = new ResumeRepository();
    }


    /**
     * показ указанного резюме
     * откликнуться, предложив вакансию
     * @param  UserResume  $resume
     * @param  ShowResumeRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(UserResume $resume, ShowResumeRequest $request)
    {
        $owner_resume = null;
        $respond_data['arr_vacancy'] = [];
        $my_user = Auth::user();
        $settings = $this->getSettingsResumeAndCountries();

        // 1 смотреть резюме
        $resume = UserResume::where('id', $request->resume_id)
            ->with('position','contact.avatar','id_saved_resumes','id_hide_resumes')
            ->first();

        if(!is_null($my_user)){
            // 2 все мои вакансии для отклика
            $respond_data['arr_vacancy'] = Vacancy::where('user_id', $my_user->id)
                ->with('position')->get();

            // если я подписан на это резюме
            if( $respond = RespondResume::where('resume_id',$request->resume_id)
                ->where('user_vacancy_id',$my_user->id)->first()
            ){
                // 3 владелец резюме - для ссылки на него для общения
                $owner_resume = User::where('id',$resume->user_id)
                    ->with('contact')->first();
            }
        }

        return view('resumes.show_resume', compact('settings','resume', 'respond_data', 'owner_resume'));
    }

    /**
     * поля создания
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $settings = $this->getSettingsResumeAndCountries();
        return view('resumes.create_resume', compact('settings'));
    }

    /**
     * создать резюме
     * @param  StoreResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreResumeRequest $request)
    {
        $resume = $this->repository->storeResume($request);
        return $this->getResponse($resume);
    }

    /**
     * открыть для редактирования
     * @param  EditResumeRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(EditResumeRequest $request)
    {
        $resume = UserResume::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->with('position')
            ->first();
        if(!$resume){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }

        $settings = $this->getSettingsResumeAndCountries();

        return view('resumes.create_resume', compact('resume','settings'));
    }

    /**
     * изменить резюме
     * @param  UpdateResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateResumeRequest $request)
    {
        if(!$resume = $this->checkMyResume($request)){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }
        $update = $this->repository->updateResume($request, $resume->position_id);

        return $this->getResponse($update);
    }

    /**
     * Все мои резюме в офисе
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myResumes()
    {
        $settings = $this->getSettingsResumeAndCountries();
        $resumes = UserResume::where('user_id', Auth::user()->id)
            ->with('position', 'contact.avatar')
            ->withCount('respond')
            ->get();

        return view('resumes.my_resumes', compact('resumes','settings'));
    }

    /**
     * обновить статус resume
     * @param  UpResumeStatusRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upResumeStatus(UpResumeStatusRequest $request)
    {
        $settings = (object) config('site.settings_vacancy');
        UserResume::where('id', $request->id)
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
     * clone resume
     * @param  DuplicateResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateResume(DuplicateResumeRequest $request)
    {
        if(!$resume = $this->checkMyResume($request)){
            return $this->getErrorResponse('Not found!');
        }

        $resume = collect($resume)->except(['id', 'updated_at', 'created_at'])->toArray();
        $resume['alias'] = sha1(time());
        $resume['published'] = 0;
        $resume['job_posting']['status_name'] = 'hidden';
        UserResume::create($resume);

        return $this->getResponse();
    }

    /**
     * добавить в закладки выбранное резюме
     * @param  SaveResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookmarkResume(SaveResumeRequest $request)
    {
        $this->switchActionResume($request, new UserSaveResume());
        return $this->getResponse();
    }

    /**
     * показ сохраненных резюме в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookmarkResumes()
    {
        $settings = $this->getSettingsResumeAndCountries();
        $resumes = UserSaveResume::where('user_id', Auth::user()->id)
            ->with('resume.position','resume.contact.avatar')
            ->get();
        return view('resumes.bookmark_resumes', compact('settings','resumes'));
    }

    /**
     * скрыть из поиска выбранное резюме
     * @param  SaveResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hideResume(SaveResumeRequest $request)
    {
        $this->switchActionResume($request, new UserHideResume());
        return $this->getResponse();
    }

    /**
     * показ скрытых резюме в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hiddenResumes()
    {
        $settings = $this->getSettingsResumeAndCountries();
        $resumes = UserHideResume::where('user_id', Auth::user()->id)
            ->with('resume.position','resume.contact.avatar')
            ->get();

        return view('resumes.hidden_resumes', compact('settings','resumes'));
    }

    // Private
    /**
     * настройки параметров и страны сайта
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getSettingsResumeAndCountries(){
        $settings = config('site.settings_vacancy');
        if($objCountries = MakeGeographyDb::where('id', 1)->select('country')->first()){
            $settings['obj_countries'] = $objCountries['country']['EN'];
        }
        $settings['categories'] = config('site.categories.categories');
        return $settings;
    }

    /**
     * проверка на мое resume
     * @param $request
     * @return mixed
     */
    private function checkMyResume($request){
        return UserResume::where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->first();
    }

    /**
     * переключение состояний резюме (добавление в закладки и скрытие)
     * @param $request
     * @param $model
     */
    private function switchActionResume($request, $model){
        if($request->action === 1){
            $model::updateOrCreate(
                [
                    'user_id'=>Auth::user()->id,
                    'resume_id'=>$request->resume_id
                ]
            );
        }
        elseif($request->action === 0){
            $model::where('user_id', Auth::user()->id)
                ->where('resume_id',$request->resume_id)
                ->delete();
        }
    }
}
