<?php
namespace App\Repositories;

use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Model\Position;
use App\Model\UserResume as Model;
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
            'contacts'=>$request->contacts,
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
