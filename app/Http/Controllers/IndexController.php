<?php
namespace App\Http\Controllers;


use App\Http\Requests\Vacancy\JobSearchRequest;
use App\Model\Position;
use App\Model\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index(Request $request) {
//        $data = Vacancy::where('vacancy_suitable->inputs->suitable_to', 60)
//            ->get();
//        $data = Vacancy::whereJsonContains('categories', '7')->get();
//        $data = Vacancy::whereJsonContains('categories', ['7', '28', '63'])->get();

//        $suitable = "19,60";
//
//        $arrSuitable = explode(",", $suitable);
//        $arrSuitable[0] = isset($arrSuitable[0]) ? intval($arrSuitable[0]) : 0;
//        $arrSuitable[1] = isset($arrSuitable[1]) ? intval($arrSuitable[1]) : 100;
//
////        dd($arrSuitable);
//
////        $model = Vacancy::when($arrSuitable , function($query) use ($arrSuitable) {
//        $model = Vacancy::where(function($query) use ($arrSuitable) {
//            $query->where(function ($query) use ($arrSuitable) {
//                $query->where("vacancy_suitable->radio_name", "set_age")
//                    ->where("vacancy_suitable->inputs->from", ">=", $arrSuitable[0])
//                    ->where("vacancy_suitable->inputs->to", "<=", $arrSuitable[1]);
//            })->orWhere(function ($query) {
//                $query->where("vacancy_suitable->radio_name", "it_not_matter");
//            });
//        })->get();
//
//
//        dd($model->toArray());





        return view('index');
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
//    public function test() {
//        for ($i=0; $i<10; $i++){
//            return $i;
//        }
//    }
}
