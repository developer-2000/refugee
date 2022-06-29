<?php
namespace App\Repositories;

use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Model\Offer;
use App\Model\Position;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\User;
use App\Model\UserResume;
use App\Model\UserResume as Model;
use App\Model\Vacancy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ResumeRepository extends CoreRepository {
    use GeneralVacancyResumeTraite;

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

    public function show($request){
        $my_user = Auth::user();
        $respond_data['arr_vacancy'] = [];
        $owner_resume = null;
        $informationRepository = new ContactInformationRepository();

        // 1 смотреть резюме
        $resume = UserResume::where('id', $request->resume_id)
            ->with('position','contact.avatar','contact.position','id_saved_resumes','id_hide_resumes')
            ->first();

        // 2 контакт лист хозяина документа
        $contact_list = $informationRepository->fillContactList($resume->contact, $resume->user_id);

        if(!is_null($my_user)){

            // я подписывался на резюме
            $respond = (new RespondResume())->selectByResumeUserVacancyId($request->resume_id, $my_user->id);
            if(is_null($respond)){
                // соискатель предложил резюме на мою вакансию
                $respond = (new RespondVacancy())->selectByResumeUserVacancyId($request->resume_id, $my_user->id);
            }

            // если я подписан на это резюме
            if( $respond ){
                // 3,1 имя хозяина документа
                $owner_resume = new \stdClass();
                $owner_resume->contact = new \stdClass();
                $owner_resume->contact->name = $resume->contact->name;

                // 3,2 alias нашего чата
                $owner_resume->offer = null;
                if($offer = (new Offer())->selectChatByUserId($resume->user_id, $my_user->id)){
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
            'resume'=>$resume,
            'respond_data'=>$respond_data,
            'owner_resume'=>$owner_resume,
            'contact_list'=>$contact_list,
        ];
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

    private function makeArrayResume($request, $position){
        return [
            'position_id'=>$position->id,
            'country' => $request->country !== null ? $request->country[0] : null,
            'region' => $request->region !== null ? $request->region[0] : null,
            'city' => $request->city !== null ? $request->city[0] : null,
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
