<?php
namespace App\Http\Controllers;


use App\Model\MakeGeographyDb;
use App\Model\Test;
use App\Model\User;
use App\Model\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index(Request $request) {
        $settings = config('site.settings_vacancy');
        if($objCountries = MakeGeographyDb::find(1)->first()->pluck('country')){
            $settings['obj_countries'] = $objCountries[0]['EN'];
        }

//        $data = Vacancy::where('vacancy_suitable->inputs->suitable_to', 60)
//            ->get();

        return view('index', compact('settings'));
    }



//    public function test() {
//        for ($i=0; $i<10; $i++){
//            return $i;
//        }
//    }
}
