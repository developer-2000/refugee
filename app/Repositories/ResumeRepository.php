<?php
namespace App\Repositories;

use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Http\Traits\Geography\GeographyForShowInterfaceTraite;
use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\Offer;
use App\Model\Position;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\UserHideResume;
use App\Model\Resume as Model;
use App\Model\UserSaveResume;
use App\Model\Vacancy;
use App\Services\LocalizationService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ResumeRepository extends CoreRepository {
    use GeneralVacancyResumeTraite, GeographyWorkSeparateEntryTraite, GeographyForShowInterfaceTraite;

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->settings = (object) config('site.settings_vacancy');
    }

    public function storeResume($request){
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        $arr = $this->makeArrayResume($request, $position);
        $arr['user_id'] = Auth::user()->id;
        $arr['alias'] = sha1(time());

        return $this->model->create($arr);
    }

    public function updateResume($request, $position_id){
        // удалить старое название, если оно не будет никем использоватся
        $this->deleteUnwantedTitle($request, $position_id);
        // создать или взять имеющееся название
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->update($this->makeArrayResume($request, $position));
    }

    public function index($request, $count_pagination){
        $my_user = Auth::user();

        // 1 фильтр выборки
        $resumes = $this->initialDataForSampling($request);

        if(!is_null($my_user)){
            // не показывать мои резюме
            $resumes = $resumes->where('user_id', '!=', $my_user->id);
            // не показывать мною скрытые резюме
            $idHide = UserHideResume::where('user_id',$my_user->id)->get()->pluck('resume_id');
            $resumes = $resumes->whereNotIn('id', $idHide);
            // 3 прошла верификацию
            $resumes = $resumes->where('published', 1);
            // 4 убрать закрытые вакансии
            $resumes = $resumes->whereJsonDoesntContain('job_posting->status_name', "hidden");
        }

        $resumes = $resumes->where('type', 0)
            ->with('position', 'contact.avatar','id_saved_resumes','id_hide_resumes','country','region','city')
            ->paginate($count_pagination);

        // 3 address
        foreach ($resumes as $key => $resume){
            $resume = $this->addPropertiesToCollection($resume);
            $resume = collect($resume);
            $resumes[$key] = $resume->except(['city','region','country']);
        }

        return $resumes;
    }

    public function show($request){
        $my_user = Auth::user();
        $respond_data['arr_vacancy'] = [];
        $owner_resume = null;
        $informationRepository = new ContactInformationRepository();
        $modalOffer = new Offer();

        $resume = $this->model->where('alias', $request->alias)
            ->with(
                'position',
                'contact.avatar',
                'contact.position',
                'id_saved_resumes',
                'id_hide_resumes',
                'country','region','city'
            )
            ->first();

        // 1 address
        $resume = $this->addPropertiesToCollection($resume);

        // документ не принадлежит этим Геоданным (Not Found)
        $elementsAddress = array_values($resume->address);
        if($request->prefix_c !== $elementsAddress[0]["original_index"] || $request->prefix_r_c !== $elementsAddress[1]["original_index"]){
            return abort(404);
        }

        // 2 контакт лист хозяина документа
        $contact_list = $informationRepository->fillContactList($resume->contact, $resume->user_id);

        if(!is_null($my_user)){

            // я подписывался на резюме
            $respond = (new RespondResume())->selectByResumeUserVacancyId($resume->id, $my_user->id);
            if(is_null($respond)){
                // соискатель предложил резюме на мою вакансию
                $respond = (new RespondVacancy())->selectByResumeUserVacancyId($resume->id, $my_user->id);
            }

            // установлен ли чат ?
            if( $respond ){
                // 3,1 имя хозяина документа
                $owner_resume = new \stdClass();
                $owner_resume->contact = new \stdClass();
                $owner_resume->contact->name = $resume->contact->name;

                // 3,2 alias нашего чата
                $owner_resume->offer = null;
                if($offer = $modalOffer->selectChatByUserId($resume->user_id, $my_user->id)){
                    $owner_resume->offer = new \stdClass();
                    $owner_resume->offer->alias = $offer->alias;
                }
            }
            else{
                // 3,1 все мои вакансии для отклика
                $respond_data['arr_vacancy'] = Vacancy::where('user_id', $my_user->id)
                    ->with('position')->get();
            }
        }

        return [
            'respond' => [
                'in_table' => $modalOffer->inTable,
                'resume' => $resume,
                'respond_data' => $respond_data,
                'owner_resume' => $owner_resume,
                'contact_list' => $contact_list,
            ]
        ];
    }

    public function myResumes(){
        $resumes = $this->model->where('user_id', Auth::user()->id)
            ->where('type', 0)
            ->with('position', 'statistic', 'contact.avatar','country','region','city')
            ->orderBy('created_at', 'desc')
            ->get();

        // address summary statistics
        foreach ($resumes as $key => $resume){
            $resume = $this->addPropertiesToCollection($resume);
            $resume = collect($resume);
            $resumes[$key] = $resume->except(['city','region','country']);
        }

        return $resumes;
    }

    /**
     * вернет мои резюме
     * @return mixed
     */
    public function getMyResumes($user){
        if(!is_null($user)){
            return $this->model->where('user_id',$user->id)
                ->get();
        }
        return null;
    }

    public function getBookmarkResumes(){
        $resumes = UserSaveResume::where('user_id', Auth::user()->id)
            ->with('resume.position','resume.contact.avatar','resume.country','resume.region','resume.city')
            ->get();

        // address
        foreach ($resumes as $key => $resume){
            $resume->resume = $this->addPropertiesToCollection($resume->resume);
        }

        return $resumes;
    }

    public function getHiddenResumes(){
        $resumes = UserHideResume::where('user_id', Auth::user()->id)
            ->with('resume.position','resume.contact.avatar','resume.country','resume.region','resume.city')
            ->get();

        // address
        foreach ($resumes as $key => $resume){
            $resume->resume = $this->addPropertiesToCollection($resume->resume);
        }

        return $resumes;
    }

    private function makeArrayResume($request, $position){
        return [
            'position_id'=>$position->id,
            'country_id' => $this->createSpecifiedLocationRecord($request, 'country', 0),
            'region_id' => $this->createSpecifiedLocationRecord($request, 'region', 1),
            'city_id' => $this->createSpecifiedLocationRecord($request, 'city', 2),
            'data_birth'=>Carbon::parse($request->data_birth),
            'categories'=>$request->categories,
            'salary'=>[
                'radio_name'=>$request->salary_but,
                'inputs'=>[
                    'from'=>$request->from,
                    'to'=>$request->to,
                    'salary_sum'=>$request->salary_sum,
                ],
                'comment'=>$request->salary_comment,
            ],
            'type_employment'=>$request->type_employment,
            'languages'=>$request->languages,
            'education'=>$request->education,
            'job_posting'=>[
                'status_name'=> $this->settings->job_status[$request->job_posting],
                'create_time'=>now(),
            ],
            'experience'=>$request->experience,
            'text_experience'=>$request->text_experience,
            'text_wait'=>$request->text_wait,
            'text_achievements'=>$request->text_achievements,
        ];
    }

}
