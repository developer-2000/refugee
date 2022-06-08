<?php
namespace App\Repositories;

use App\Http\Traits\CountPositionTraite;
use App\Model\Position;
use App\Model\Vacancy as Model;
use Illuminate\Support\Facades\Auth;


class VacancyRepository extends CoreRepository {
    use CountPositionTraite;

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->settings = (object) config('site.settings_vacancy');
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
        $this->deleteUnwantedVacancyTitle($request, $position_id);
        // создать или взять имеющееся название
        $position = Position::firstOrCreate(
            ['title' => mb_strtolower($request->position, 'UTF-8')]
        );

        return $this->model->where('id', $request->id)
            ->where('user_id', Auth::user()->id)
            ->update($this->makeArrayVacancy($request, $position));
    }

    public function initialDataForSampling($request){
        $this->model = $this->searchByPositionWithSorting($request);
        $this->model = $this->countrySearch($request);
        $this->model = $this->regionSearch($request);
        $this->model = $this->citySearch($request);
        $this->model = $this->categorySearch($request);
        $this->model = $this->languageSearch($request);
        $this->model = $this->suitableSearch($request);
        $this->model = $this->employmentSearch($request);
        $this->model = $this->salarySearch($request);
        $this->model = $this->experienceSearch($request);
        $this->model = $this->educationSearch($request);

        return $this->model;
    }

    /**
     * поиск по заголовку с сортировкой
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function searchByPositionWithSorting($request){
        if (isset($request->position)) {
            $stroke = '0';
            $arrPosition = explode(" ", $request->position);

            $coll = Position::when($arrPosition , function($query) use ($arrPosition) {
                $query->where(function ($query) use ($arrPosition) {
                    foreach($arrPosition as $word) {
                        $query->orWhere('title', 'like', '%' . $word . '%');
                    }
                });
            })->orderBy('title', 'asc')->get();

            if($coll->count()){
                $coll = $coll->pluck('id')->toArray();
                $stroke = implode(',',$coll);
            }

            $this->model = $this->model->whereIn('position_id', $coll)
                ->orderByRaw("field(position_id,{$stroke})", $coll);
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
                        $query->orWhereJsonContains('categories', intval($id));
                    }
                });
            });
        }

        return $this->model;
    }

    /**
     * переберает ['7', '28', '63'] и выбирает каждый в котором есть хоть один
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function languageSearch($request){
        if (isset($request->languages)) {
            $languages = explode(",", $request->languages);

            $this->model = $this->model->when($languages , function($query) use ($languages) {
                $query->where(function ($query) use ($languages) {
                    foreach($languages as $id) {
                        $query->orWhereJsonContains('languages', intval($id));
                    }
                });
            });
        }

        return $this->model;
    }

    /**
     * выбрать возраст - диапозон больше меньше или статус - не важно
     * @param $request
     * @return \Illuminate\Contracts\Container\ContextualBindingBuilder|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function suitableSearch($request){
        if (isset($request->suitable)) {
            $arrSuitable = explode(",", $request->suitable);
            $arrSuitable[0] = isset($arrSuitable[0]) ? intval($arrSuitable[0]) : 0;
            $arrSuitable[1] = isset($arrSuitable[1]) ? intval($arrSuitable[1]) : 100;

            $this->model = $this->model->where(function($query) use ($arrSuitable) {
                $query->where(function ($query) use ($arrSuitable) {
                    $query->where("vacancy_suitable->radio_name", "set_age")
                        ->where("vacancy_suitable->inputs->from", ">=", $arrSuitable[0])
                        ->where("vacancy_suitable->inputs->to", "<=", $arrSuitable[1]);
                })->orWhere(function ($query) {
                    $query->where("vacancy_suitable->radio_name", "it_not_matter");
                });
            });
        }

        return $this->model;
    }

    /**
     * полная или удаженная работа
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function employmentSearch($request){
        if (isset($request->employment)) {
            $this->model = $this->model->where('type_employment', $request->employment);
        }

        return $this->model;
    }

    /**
     * зарплата вакансии
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function salarySearch($request){
        if (isset($request->salary)) {
            $arrStroke = explode(",", $request->salary);
            $arrStroke[0] = isset($arrStroke[0]) ? intval($arrStroke[0]) : 0;
            $arrStroke[1] = isset($arrStroke[1]) ? intval($arrStroke[1]) : 0;
            $arrStroke[2] = isset($arrStroke[2]) ? intval($arrStroke[2]) : 99999;

            // поиск по - ЗП не указана
            if($arrStroke[0] === 1){
                $this->model = $this->model->where("salary->radio_name", 'dont_specify');
            }
            // поиск по интервал от и до либо фиксированная ЗП
            else{
                $this->model = $this->model->where(function($query) use ($arrStroke) {
                    $query->where(function ($query) use ($arrStroke) {
                        $query->where("salary->radio_name", 'range')
                            ->where("salary->inputs->from", ">=", $arrStroke[1])
                            ->where("salary->inputs->to", "<=", $arrStroke[2]);
                    })->orWhere(function ($query) use ($arrStroke) {
                        $query->where("salary->radio_name", 'single_value')
                            ->where("salary->inputs->salary_sum", ">=", $arrStroke[1])
                            ->where("salary->inputs->salary_sum", "<=", $arrStroke[2]);
                    });
                });
            }
        }

        return $this->model;
    }

    /**
     * опыт работы
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function experienceSearch($request){
        if (isset($request->experience)) {
            $this->model = $this->model->where('experience', $request->experience);
        }

        return $this->model;
    }

    /**
     * образование соискателя
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function educationSearch($request){
        if (isset($request->education)) {
            $this->model = $this->model->where('education', $request->education);
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
