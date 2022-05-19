<?php
namespace App\Http\Controllers;


use App\Http\Requests\Vacancy\JobSearchRequest;
use App\Model\Position;
use App\Model\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index(Request $request) {

        return view('index');
    }

}
