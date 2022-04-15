<?php
namespace App\Repositories;

use App\Model\Position;
use App\Model\Test;
use App\Model\Vacancy;
use App\Model\Vacancy as Model;
use Illuminate\Support\Facades\Auth;

class VacancyRepository extends CoreRepository {

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->settings = (object) config('site.settings_vacancy');
    }

    public function storeVacancy($request){
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->create([
            'user_id'=>Auth::user()->id,
            'position_id'=>$position->id,
            'categories'=>$request->categories,
            'country'=>$request->country !== null ? $request->country[0] : null,
            'region'=>$request->region !== null ? $request->region[0] : null,
            'city'=>$request->city !== null ? $request->city[0] : null,
            'rest_address'=>$request->rest_address,
            'vacancy_suitable'=>[
                'checkboxes'=>$request->vacancy_suitable,
                'comment'=>$request->commentary_age,
            ],
            'type_employment'=>$request->type_employment,
            'salary'=>[
                'radio_name'=>$request->salary_but,
                'inputs'=>[
                    'salary_from'=>$request->salary_from,
                    'salary_to'=>$request->salary_to,
                    'salary_sum'=>$request->salary_sum,
                ],
                'comment'=>$request->salary_comment,
            ],
            'experience'=>$request->experience,
            'education'=>$request->education,
            'search_city'=>[
                'bool'=>$request->checkbox_city,
                'code'=>$request->search_city,
            ],
            'text_requirements'=>$request->text_requirements,
            'text_working'=>$request->text_working,
            'text_responsibilities'=>$request->text_responsibilities,
            'contacts'=>$request->contacts,
            'how_respond'=>$request->how_respond,
            'job_posting'=>[
                'status_name'=> $this->settings->job_status[$request->job_posting],
                'create_time'=>now(),
            ],
            'alias'=>sha1(time()),
        ]);

    }

    public function updateVacancy($request){
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->update([
            'position_id'=>$position->id,
            'categories'=>$request->categories,
            'country'=>$request->country !== null ? $request->country[0] : null,
            'region'=>$request->region !== null ? $request->region[0] : null,
            'city'=>$request->city !== null ? $request->city[0] : null,
            'rest_address'=>$request->rest_address,
            'vacancy_suitable'=>[
                'checkboxes'=>$request->vacancy_suitable,
                'comment'=>$request->commentary_age,
            ],
            'type_employment'=>$request->type_employment,
            'salary'=>[
                'radio_name'=>$request->salary_but,
                'inputs'=>[
                    'salary_from'=>$request->salary_from,
                    'salary_to'=>$request->salary_to,
                    'salary_sum'=>$request->salary_sum,
                ],
                'comment'=>$request->salary_comment,
            ],
            'experience'=>$request->experience,
            'education'=>$request->education,
            'search_city'=>[
                'bool'=>$request->checkbox_city,
                'code'=>$request->search_city,
            ],
            'text_requirements'=>$request->text_requirements,
            'text_working'=>$request->text_working,
            'text_responsibilities'=>$request->text_responsibilities,
            'contacts'=>$request->contacts,
            'how_respond'=>$request->how_respond,
            'job_posting'=>[
                'status_name'=> $this->settings->job_status[$request->job_posting],
                'create_time'=>now(),
            ],
            'alias'=>sha1(time()),
        ]);

    }
}
