<?php
namespace App\Http\Controllers;


use App\Http\Requests\Vacancy\JobSearchRequest;
use App\Model\GeographyDb;
use App\Model\GeographyLocal;
use App\Model\GeographyTranslate;
use App\Model\Image;
use App\Model\Position;
use App\Model\Test;
use App\Model\UserResume;
use App\Model\Vacancy;
use App\Repositories\OfferRepository;
use App\Services\LocalizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
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

//        $this->test();

        $transition_url_page = null;
        // если пользователь шел на закрытый auth url (переход туда куда шел изначально)
        if($arr = Session::pull('transition_after_auth', null)){
            $transition_url_page = $arr['url_page'];
        }

        $respond = [
            'obj_countries' => (new LocalizationService())->getCountries(App::getLocale()),
        ];

        $respond['now_country'] = null;
        $respond['regions_country'] = null;
        $respond['now_region'] = null;
        $respond['cities_region'] = null;
        $respond['now_city'] = null;

        return view('index', compact('transition_url_page','respond'));
    }

    public function test() {


//        (new \App\Services\MakeLocationDbServices());

//        $locationCities = GeographyTranslate::select('cities')->firstWhere('id', 1);
//        $allCities = (new LocalizationService())->getCities('ru', $locationCities);
//
//        dd($allCities);
    }






}
