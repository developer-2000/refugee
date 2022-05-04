<?php
namespace App\Repositories;

use App\Model\Position;
use App\Model\Test;
use App\Model\Vacancy;
use App\Model\Vacancy as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $arr = $this->makeArrayVacancy($request, $position);
        $arr['user_id'] = Auth::user()->id;
        $arr['alias'] = sha1(time());
        return $this->model->create($arr);
    }

    public function updateVacancy($request){
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->where('id', $request->vacancy_id)
            ->where('user_id', Auth::user()->id)
            ->update($this->makeArrayVacancy($request, $position));
    }

    public function initialDataForSampling($request){
        $this->model = $this->searchByPositionWithSorting($request);
        $this->model = $this->countrySearch($request);
        $this->model = $this->regionSearch($request);
        $this->model = $this->citySearch($request);
        $this->model = $this->categorySearch($request);

        return $this->model;
    }

    /**
     * поиск по заголовку с сортировкой
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function searchByPositionWithSorting($request){
        if (isset($request->position)) {
            $coll = (new Position())->where('title', 'like', '%' . $request->position . '%')
                ->orderBy('title', 'asc')
                ->get();

            if($coll->count()){
                $coll = $coll->pluck('id')->toArray();
                $stroke = implode(',',$coll);
                $this->model = $this->model->whereIn('position_id', $coll)
                    ->orderByRaw("field(position_id,{$stroke})", $coll);
            }
        }

        return $this->model;
    }

    /**
     * поиск по префиксу страны
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function countrySearch($request){
        if (isset($request->country)) {
            $this->model = $this->model->where('country', 'like', '%' . $request->country . '%');
        }

        return $this->model;
    }

    /**
     * поиск по префиксу региона
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function regionSearch($request){
        if (isset($request->region)) {
            $this->model = $this->model->where('region', 'like', '%' . $request->region . '%');
        }

        return $this->model;
    }

    /**
     * поиск по префиксу города
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function citySearch($request){
        if (isset($request->city)) {
            $this->model = $this->model->where('city', 'like', '%' . $request->city . '%');
        }

        return $this->model;
    }

    /**
     * переберает ['7', '28', '63'] и выбирает каждый в котором есть хоть один
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function categorySearch($request){
        if (isset($request->categories)) {
            $categories = explode(",", $request->categories);

            $this->model = $this->model->when($categories , function($query) use ($categories) {
                $query->where(function ($query) use ($categories) {
                    foreach($categories as $id) {
                        $query->orWhereJsonContains('categories', $id);
                    }
                });
            });
        }

        return $this->model;
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
            'contacts'=>$request->contacts,
            'how_respond'=>$request->how_respond,
            'job_posting'=>[
                'status_name'=> $this->settings->job_status[$request->job_posting],
                'create_time'=>now(),
            ],
        ];
    }

}
