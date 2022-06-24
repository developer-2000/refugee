<?php
namespace App\Repositories;

use App\Http\Traits\GeneralVacancyResumeTraite;
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

        // 1 смотреть резюме
        $resume = UserResume::where('id', $request->resume_id)
            ->with('position','contact.avatar','contact.position','id_saved_resumes','id_hide_resumes')
            ->first();

        // 4 заполить контакт лист
        $contact_list = (new ContactInformationRepository())->fillContactList($resume->contact, $resume->user_id);

        if(!is_null($my_user)){

            $respond = RespondResume::where('resume_id',$request->resume_id)
                ->select('id')->where('user_vacancy_id',$my_user->id)->first();
            if(is_null($respond)){
                $respond = RespondVacancy::where('resume_id',$request->resume_id)
                    ->select('id')->where('user_vacancy_id',$my_user->id)->first();
            }

            // если я подписан на это резюме OR
            // работник ранее предоставил мне его в качестве предложения
            if( $respond ){
                // 3 владелец резюме для ссылки на него для общения
                $owner_resume = User::where('id',$resume->user_id)
                    ->with('contact')->first();
            }
            else{
                // 2 все мои вакансии для отклика
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
