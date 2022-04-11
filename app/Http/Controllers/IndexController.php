<?php
namespace App\Http\Controllers;


use App\Model\MakeGeographyDb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index(Request $request) {
        return view('index');
    }



//    public function test() {
//        for ($i=0; $i<10; $i++){
//            return $i;
//        }
//    }
}
