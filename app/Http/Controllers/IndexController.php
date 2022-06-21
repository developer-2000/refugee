<?php
namespace App\Http\Controllers;


use App\Http\Requests\Vacancy\JobSearchRequest;
use App\Model\Image;
use App\Model\Position;
use App\Model\Test;
use App\Model\Vacancy;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller {

    /**
     * transition_after_auth - создаетса в middleware auth
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $transition_url_page = null;
        // если пользователь шел на закрытый auth url
        if($arr = Session::pull('transition_after_auth', null)){
            $transition_url_page = $arr['url_page'];
        }

        return view('index', compact('transition_url_page'));
    }

}
