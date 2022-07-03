<?php

namespace App\Http\Controllers;

use App\Http\Requests\Resume\EditResumeRequest;
use App\Http\Requests\Resume\IndexResumeRequest;
use App\Http\Requests\Resume\SaveResumeRequest;
use App\Http\Requests\Resume\ShowResumeRequest;
use App\Http\Requests\Resume\StoreResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Http\Requests\Resume\UpResumeStatusRequest;
use App\Http\Requests\Resume\DuplicateResumeRequest;
use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Model\RespondResume;
use App\Model\UserHideResume;
use App\Model\UserResume;
use App\Model\UserSaveResume;
use App\Repositories\ResumeRepository;
use Illuminate\Support\Facades\Auth;

class ResumeController extends BaseController {
    use GeneralVacancyResumeTraite;

    protected $repository;

    public function __construct() {
        parent::__construct();
        $this->repository = new ResumeRepository();
    }

    public function index(IndexResumeRequest $request)
    {
        $my_user = Auth::user();
        $ids_respond = [];
        // 1
        $settings = $this->getSettingsDocumentsAndCountries();
        // 2 фильтр выборки
        $resumes = $this->repository->initialDataForSampling($request);

        if(!is_null($my_user)){
            // 3 не показывать мои резюме
            $resumes = $resumes->where('user_id', '!=', $my_user->id);
            // 4 не показывать мною скрытые резюме
            $idHide = UserHideResume::where('user_id',$my_user->id)->get()->pluck('resume_id');
            $resumes = $resumes->whereNotIn('id', $idHide);
        }

        $resumes = $resumes->where('type', 0)
            ->with('position', 'contact.avatar','id_saved_resumes','id_hide_resumes','country','region','city')
            ->paginate(10);

        // 5 выбрать id резюме на которые я уже откликнулся (отображение что откликнулся)
        $idResumes = $resumes->pluck('id');
        if(!is_null($my_user)){
            $ids_respond = RespondResume::where('user_vacancy_id',$my_user->id)
                ->whereIn('resume_id',$idResumes)->get()->pluck('resume_id');
        }

        return view('search_resumes', compact('settings', 'resumes', 'ids_respond'));
    }

    /**
     * показ указанного резюме
     * откликнуться, предложив вакансию
     * выбираю:
     * 1 резюме,
     * 2 мои вакансии для отклика,
     * 3 владелец документа для ссылки на него
     * 4
     * @param  UserResume  $resume
     * @param  ShowResumeRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(UserResume $resume, ShowResumeRequest $request)
    {
        $arrData = $this->repository->show($request);
        $settings = $this->getSettingsDocumentsAndCountries();
        $settings['contact_information'] = config('site.contacts.contact_information');
        $arrData['respond']['settings'] = $settings;

        return view('resumes.show_resume', $arrData);
    }

    /**
     * поля создания
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
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
            ->with('position','country','region','city')
            ->first();
        if(!$resume){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }

        $settings = $this->getSettingsDocumentsAndCountries();

        return view('resumes.create_resume', compact('resume','settings'));
    }

    /**
     * изменить резюме
     * @param  UpdateResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateResumeRequest $request)
    {
        if(!$resume = $this->checkMyDocument($request, new UserResume())){
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
        $settings = $this->getSettingsDocumentsAndCountries();
        $resumes = UserResume::where('user_id', Auth::user()->id)
            ->with('position', 'contact.avatar','country','region','city')
            ->withCount('respond')
            ->orderBy('created_at', 'desc')
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
        if(!$resume = $this->checkMyDocument($request, new UserResume())){
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
    public function setBookmarkResume(SaveResumeRequest $request)
    {
        $this->switchActionBookmark($request, new UserSaveResume(), 'resume_id');
        return $this->getResponse();
    }

    /**
     * показ сохраненных резюме в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBookmarkResumes()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $resumes = UserSaveResume::where('user_id', Auth::user()->id)
            ->with('resume.position','resume.contact.avatar','resume.country','resume.region','resume.city')
            ->get();
        return view('resumes.bookmark_resumes', compact('settings','resumes'));
    }

    /**
     * скрыть из поиска выбранное резюме
     * @param  SaveResumeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setHideResume(SaveResumeRequest $request)
    {
        $this->switchActionBookmark($request, new UserHideResume(), 'resume_id');
        return $this->getResponse();
    }

    /**
     * показ скрытых резюме в закладках
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHiddenResumes()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $resumes = UserHideResume::where('user_id', Auth::user()->id)
            ->with('resume.position','resume.contact.avatar','resume.country','resume.region','resume.city')
            ->get();

        return view('resumes.hidden_resumes', compact('settings','resumes'));
    }

}
