<?php
namespace App\Http\Controllers;


use App\Http\Requests\Vacancy\JobSearchRequest;
use App\Model\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index(Request $request) {
//        $data = Vacancy::where('vacancy_suitable->inputs->suitable_to', 60)
//            ->get();
//        $data = Vacancy::whereJsonContains('categories', '7')->get();
//        $data = Vacancy::whereJsonContains('categories', ['7', '28', '63'])->get();

        return view('index');
    }


//    public function test() {
//        for ($i=0; $i<10; $i++){
//            return $i;
//        }
//    }
}
