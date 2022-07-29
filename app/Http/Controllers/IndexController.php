<?php
namespace App\Http\Controllers;

use App\Http\Traits\MetaTrait;
use App\Model\User;
use App\Services\LocalizationService;
use App\Services\MetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class IndexController extends Controller {
    use MetaTrait;

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

        $respond = config('site.search_title_panel.collection_location');
        $respond['obj_countries'] = (new LocalizationService())->getCountries(App::getLocale());

        $this->setMetaIndexPage();

        return view('index', compact('transition_url_page','respond'));
    }

//    private function test() {
//
////        $users = User::with('permission')->get();
////
////        foreach ($users as $key => $user){
////            dump($user->toArray());
////        }
//
//    }

}
