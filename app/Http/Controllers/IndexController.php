<?php
namespace App\Http\Controllers;

use App\Http\Requests\Feedback\FeedbackSendMessageRequest;
use App\Http\Traits\MetaTrait;
use App\Jobs\SendFeedbackMessage;
use App\Repositories\ResumeRepository;
use App\Services\LanguageService;
use App\Services\LocalizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class IndexController extends BaseController {
    use MetaTrait;

    public function __construct() {
        parent::__construct();
        $service = new LanguageService();
        App::setLocale($service->selectLangFromUrl());
    }

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

    public function aboutUs() {
        $this->setMetaAboutUsPage();
        $domain = env("APP_DOMAIN", "");

        return view("about_us.about_us_".app()->getLocale(), compact("domain"));
    }

    public function feedback() {
        $respond = [ "contact" => null ];
        if(!is_null(Auth::user())){
            $respond["contact"] = Auth::user()->contact->only(['full_name', 'email']);
        }

        $respond["config"] = config('site.feedback');

        $this->setMetaFeedbackPage();

        return view("feedback", compact('respond'));
    }

    public function feedbackSendMessage(FeedbackSendMessageRequest $request) {

        SendFeedbackMessage::dispatch($request->validated())
            ->onQueue('emails');

        return $this->getResponse();
    }

    // php artisan queue:listen --queue=default
    public function test() {

//        Artisan::call('queue:work --queue=default --stop-when-empty', []);

    }

}
