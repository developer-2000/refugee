<?php
namespace App\Http\Controllers;

use App\Http\Requests\Feedback\FeedbackSendMessageRequest;
use App\Http\Traits\SharingTraite;
use App\Jobs\SendFeedbackMessage;
use App\Model\Resume;
use App\Model\Vacancy;
use App\Services\InstrumentService;
use App\Services\LanguageService;
use App\Services\LocalizationService;
use App\Services\MetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class IndexController extends BaseController {
    use SharingTraite;

    protected $metaService = '';

    public function __construct() {
        parent::__construct();
        // установка lang из url
        $service = new LanguageService();
        App::setLocale($service->selectLangFromUrl());
        // мета сервис
        $this->metaService = new MetaService();
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

        // 1 установить мета теги страницы
        $this->metaService->setMetaIndexPage();

        // 2 установить meta Open Graph
        $config = config('site.open_graph');
        $config["title_page"] = __('meta_tags.index_page.title');
        $desc = trim(__('meta_tags.index_page.description'));
        $desc = (new InstrumentService())->firstSymbolStringUppercase($desc);
        $config["description"] = $desc;

        $this->metaService->setOpenGraph($config);

        // 3 установить meta Twitter Card
        $this->metaService->setTwitterCard($config);

        // 4 вернуть ссылки Sharing соц-сетей
        $respond["social_share"] = $this->getLinksShare();

        return view('index', compact('transition_url_page','respond'));
    }

    public function aboutUs() {
        $this->metaService->setMetaAboutUsPage();
        $domain = env("APP_DOMAIN", "");

        return view("about_us.about_us_".app()->getLocale(), compact("domain"));
    }

    public function feedback() {
        $respond = [ "contact" => null ];
        if(!is_null(Auth::user())){
            $respond["contact"] = Auth::user()->contact->only(['full_name', 'email']);
        }

        $respond["config"] = config('site.feedback');

        $this->metaService->setMetaFeedbackPage();

        return view("feedback", compact('respond'));
    }

    public function feedbackSendMessage(FeedbackSendMessageRequest $request) {

        SendFeedbackMessage::dispatch($request->validated())
            ->onQueue('emails');

        return $this->getResponse();
    }

//    {"status_name":"standard","create_time":"2022-09-03T12:39:43.761498Z"}
    public function test() {

    }


}
