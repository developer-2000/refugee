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
use App\Http\Traits\SharingTraite;
use App\Jobs\Statistics\IncreaseNumberShowResume;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\Resume;
use App\Model\UserHideResume;
use App\Model\UserSaveResume;
use App\Repositories\ResumeRepository;
use App\Services\LanguageService;
use App\Services\MetaService;
use App\Services\StatisticResumesService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Jorenvh\Share\ShareFacade;

class ResumeController extends BaseController {
    use GeneralVacancyResumeTraite, SharingTraite;

    protected $repository;
    protected $count_pagination;

    public function __construct() {
        parent::__construct();
        $this->repository = new ResumeRepository();
        $this->count_pagination = 20;
        $service = new LanguageService();
        App::setLocale($service->selectLangFromUrl());
    }

    public function index(IndexResumeRequest $request, $country = null, $city = null) {
        $metaService = new MetaService();
        $my_user = Auth::user();
        $ids_respond = [];

        // 1 выборка с пагинацией
        $resumes = $this->repository->index($request, $this->count_pagination);

        // 2 выбрать id резюме на которые я уже откликнулся (отображение в интерфейсе)
        $idResumes = $resumes->pluck('id');
        if(!is_null($my_user)){
            $ids_respond = RespondResume::where('user_vacancy_id',$my_user->id)
                ->whereIn('resume_id',$idResumes)
                ->get()->pluck('resume_id')->toArray();

            $ids_respond2 = RespondVacancy::where('user_vacancy_id',$my_user->id)
                ->whereIn('resume_id',$idResumes)
                ->get()->pluck('resume_id')->toArray();

            $ids_respond = array_merge($ids_respond, $ids_respond2);
        }

        // 3 увеличить кол-во показов
        IncreaseNumberShowResume::dispatch([
            "arr_id_resumes"=>$idResumes,
        ])->onQueue('default');

        // 4 набор данных по геолокации
        $respond = $this->repository->indexRespond($request);
        $respond['resumes'] = $resumes;
        $respond['ids_respond'] = $ids_respond;

        // 5 установить мета теги страницы
        $metaService->setMetaAllResumesPage($respond);

        // 6 установить  meta Open Graph
        $config = config('site.open_graph');
        $location_now = $metaService->checkLocation($respond);

        // 6.1 все резюме
        if( $location_now === "all_documents" ){
            $config["title_page"] = __('meta_tags.all_resumes.title');
            $desc = trim(__('meta_tags.all_resumes.description'));
            $config["description"] = $desc;
        }
        // 6.2 резюме страны
        elseif ( $location_now === "country" ){
            $config["title_page"] = __('meta_tags.resumes_country.title', ["country"=>$respond["now_country"]["translate"]]);
            $config["description"] = __('meta_tags.resumes_country.description', [ "country"=>$respond["now_country"]["translate"], "site"=>config('app.name', "") ]);
        }
        // 6.3 резюме региона или города
        elseif ( $location_now === "city" ){
            $city = !is_null($respond["now_city"]) ? $respond["now_city"]["translate"] : $respond["now_region"]["translate"];

            $config["title_page"] = __('meta_tags.resumes_city.title', [
                "city"=>$city,
                'country' => $respond["now_country"]["translate"]
            ]);
            $config["description"] = __('meta_tags.resumes_city.description', ["city"=>$city, "country"=>$respond["now_country"]["translate"], ])
                .config('app.name', "");
        }

        $metaService->setOpenGraph($config);

        // 7 установить meta Twitter Card
        $metaService->setTwitterCard($config);

        // 8 вернуть ссылки Sharing соц-сетей
        $respond["social_share"] = $this->getLinksShare();

        return view('search_resumes', compact('respond'));
    }

    /**
     * показ указанного резюме
     * откликнуться, предложив вакансию
     * выбираю:
     * 1 резюме,
     * 2 мои вакансии для отклика,
     * 3 владелец документа для ссылки на него
     * 4
     * @param  ShowResumeRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ShowResumeRequest $request) {
        $metaService = new MetaService();
        $arrData = $this->repository->show($request);
        $settings = $this->getSettingsDocumentsAndCountries();
        $settings['contact_information'] = config('site.contacts.contact_information');
        $arrData['respond']['settings'] = $settings;

        // количество просмотров
        $statisticService = new StatisticResumesService();
        $statisticService->increaseNumberView($arrData["respond"]["resume"]["id"]);

        $resumeArr = $arrData['respond']["resume"]->toArray();
        // 1 установить мета теги страницы
        $metaService->setMetaShowResumePage($resumeArr);

        // 6 установить meta Open Graph
        $config = config('site.open_graph');
        $address = isset($resumeArr["address"]["city"]) ? $resumeArr["address"]["city"]["translate"] : $resumeArr["address"]["region"]["translate"];
        $user_name = $resumeArr['contact']['full_name'];

        $config["title_page"] = __('meta_tags.show_resume.title', [
            "title"=>$resumeArr["position"]["title"],
            "address"=>$address,
            'user_name' => $user_name
        ]);
        $config["description"] = __('meta_tags.show_resume.description', [ "title"=>$resumeArr["position"]["title"] ]).config('app.name', "");

        $metaService->setOpenGraph($config);

        // 3 установить meta Twitter Card
        $metaService->setTwitterCard($config);

        // 4 вернуть ссылки Sharing соц-сетей
        $arrData["respond"]["social_share"] = $this->getLinksShare();

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
        $resume = Resume::where('id', $request->id)
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
        if( !$resume = $this->checkMyDocument($request, new Resume()) ){
            return redirect()->back()->withErrors(['message'=>'Not found!']);
        }
        $update = $this->repository->updateResume($request, $resume->position_id);

        // количество обновлений
        $statisticService = new StatisticResumesService();
        $statisticService->increaseNumberUpdate($request->id);

        return $this->getResponse($update);
    }

    /**
     * Все мои резюме в офисе
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myResumes()
    {
        $settings = $this->getSettingsDocumentsAndCountries();
        $resumes = $this->repository->myResumes();

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
        Resume::where('id', $request->id)
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
        if(!$resume = $this->checkMyDocument($request, new Resume())){
            return $this->getErrorResponse('Not found!');
        }

        $resume = collect($resume)->except(['id', 'updated_at', 'created_at'])->toArray();
        $resume['alias'] = sha1(time());
        $resume['published'] = 0;
        $resume['job_posting']['status_name'] = 'hidden';
        Resume::create($resume);

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
        $resumes = $this->repository->getBookmarkResumes();

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
        $resumes = $this->repository->getHiddenResumes();

        return view('resumes.hidden_resumes', compact('settings','resumes'));
    }

}
