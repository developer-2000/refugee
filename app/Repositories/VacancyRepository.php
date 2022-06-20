<?php
namespace App\Repositories;

use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Model\Position;
use App\Model\RespondVacancy;
use App\Model\User;
use App\Model\UserResume;
use App\Model\Vacancy;
use App\Model\Vacancy as Model;
use Illuminate\Support\Facades\Auth;

class VacancyRepository extends CoreRepository {
    use GeneralVacancyResumeTraite;

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->settings = (object) config('site.settings_vacancy');
    }

    public function storeVacancy($request){
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );
        $arr = $this->makeArrayVacancy($request, $position);
        $arr['user_id'] = Auth::user()->id;
        $arr['alias'] = sha1(time());
        return $this->model->create($arr);
    }

    public function updateVacancy($request, $position_id){
        // удалить старое название, если оно не будет никем использоватся
        $this->deleteUnwantedTitle($request, $position_id);
        // создать или взять имеющееся название
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->update($this->makeArrayVacancy($request, $position));
    }

    public function show($request){
        $my_user = Auth::user();
        $respond_data['arr_resume'] = [];
        $owner_vacancy = null;

        // 1 смотреть вакансию
        $vacancy = Vacancy::where('id', $request->vacancy_id)
            ->with(
                'position',
                'contact.avatar',
                'contact.position',
                'company.image',
                'id_saved_vacancies',
                'id_hide_vacancies'
            )
            ->first();

        // 4 заполить контакт лист
        $contact_list = (new ContactInformationRepository())->fillContactList($vacancy);

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

        return [
            'vacancy'=>$vacancy,
            'respond_data'=>$respond_data,
            'owner_vacancy'=>$owner_vacancy,
            'contact_list'=>$contact_list,
        ];
    }

    /**
     * вернет мои вакансии
     * @return mixed
     */
    public function getMyVacancies($user){
        if(!is_null($user)){
            return $this->model->where('user_id',$user->id)
                ->get();
        }
        return null;
    }

    private function makeArrayVacancy($request, $position){
        return [
            'position_id'=>$position->id,
            'categories'=>$request->categories,
            'languages'=>$request->languages,
            'country'=>$request->country !== null ? $request->country[0] : null,
            'region'=>$request->region !== null ? $request->region[0] : null,
            'city'=>$request->city !== null ? $request->city[0] : null,
            'rest_address'=>$request->rest_address,
            'vacancy_suitable'=>[
                'radio_name'=>$request->vacancy_suitable,
                'inputs'=>[
                    'from'=>$request->suitable_from,
                    'to'=>$request->suitable_to,
                ],
                'comment'=>$request->suitable_commentary,
            ],
            'type_employment'=>$request->type_employment,
            'salary'=>[
                'radio_name'=>$request->salary_but,
                'inputs'=>[
                    'from'=>$request->from,
                    'to'=>$request->to,
                    'salary_sum'=>$request->salary_sum,
                ],
                'comment'=>$request->salary_comment,
            ],
            'experience'=>$request->experience,
            'education'=>$request->education,
            'text_description'=>$request->text_description,
            'text_working'=>$request->text_working,
            'text_responsibilities'=>$request->text_responsibilities,
            'how_respond'=>$request->how_respond,
            'job_posting'=>[
                'status_name'=> $this->settings->job_status[$request->job_posting],
                'create_time'=>now(),
            ],
        ];
    }

}
