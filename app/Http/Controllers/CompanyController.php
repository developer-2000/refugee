<?php
namespace App\Http\Controllers;

use App\Http\Requests\Company\CheckTransliterationRequest;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Traits\Geography\GeographyForShowInterfaceTraite;
use App\Http\Traits\SharingTraite;
use App\Jobs\Statistics\IncreaseNumberShowJob;
use App\Model\UserCompany;
use App\Repositories\CompanyRepository;
use App\Repositories\ContactInformationRepository;
use App\Repositories\OfferArchiveRepository;
use App\Repositories\OfferRepository;
use App\Services\LocalizationService;
use App\Services\MetaService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CompanyController extends BaseController {
    use GeographyForShowInterfaceTraite, SharingTraite;

    protected $repository;

    public function __construct() {
        $this->repository = new CompanyRepository();
    }

    /**
     * Вывод полей создания / редактирования своей компании
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $settings = $this->getSettings();
        $company = UserCompany::where('user_id', Auth::user()->id)
            ->with('image', 'country', 'region', 'city')->first();

        return view('my_company', compact('company','settings'));
    }

    /**
     * создание своей компании
     * @param  StoreCompanyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCompanyRequest $request) {
        $store = $this->repository->storeCompany($request);

        return $this->getResponse();
    }

    public function update(UpdateCompanyRequest $request) {
        // моей компании не существует
        if(!$company = UserCompany::where('id', $request->company_id)->where('user_id', Auth::user()->id)->first() ){
            return $this->getErrorResponse('Not found!');
        }

        $bool = $this->repository->updateCompany($request, $company);
        return $this->getResponse();
    }

    /**
     * показ указаной компании
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($alias){
        $metaService = new MetaService();
        $my_user = Auth::user();
        $company = UserCompany::where('alias', $alias)
            ->with(
                'image',
                'vacancies.position',
                'vacancies.company.image',
                'vacancies.id_saved_vacancies',
                'vacancies.id_hide_vacancies',
                'vacancies.country','vacancies.region','vacancies.city',
                'contact.avatar',
                'contact.position',
                'country',
                'region',
                'city'
            )->firstOrFail();

        // 1 заполить контакт лист
        $contact_list = (new ContactInformationRepository())->fillContactList(
            $company->contact, $company->user_id
        );
        $contact_list['offer_url'] = null;

        // 2 добавить url нашего чата
        if(!is_null($my_user)){
            $ourOffer = (new OfferRepository())->getOurChat($company->user_id, $my_user->id);
            if(is_null($ourOffer)){
                if($ourOffer = (new OfferArchiveRepository())->getOurChat($company->user_id, $my_user->id)){
                    $contact_list['offer_url'] = "offers/archive/$ourOffer->alias";
                }
            }
            else{
                $contact_list['offer_url'] = "offers/$ourOffer->alias";
            }
        }

        $settings = config('site.settings_vacancy');
        $settings['categories'] = config('site.categories.categories');
        $settings['count_working'] = config('site.company.count_working');
        $settings['contact_information'] = config('site.contacts.contact_information');

        // 3 добавить данные адреса
        $company = $this->addPropertiesToCollection($company);
        $company = collect($company);
        $company = $company->except(['city', 'region', 'country']);
        $vacancies = $company['vacancies'];
        foreach ($vacancies as $key => $vacancy){
            $vacancy = collect($vacancy);
            $vacancy = $this->addPropertiesToCollection_ForAffectedCollection($vacancy);
            $vacancies[$key] = $vacancy->except(['city', 'region', 'country']);
        }
        $company['vacancies'] = $vacancies;

        // 3 увеличить кол-во показов вакансий
        $idVacancies = collect($company['vacancies'])->pluck("id")->toArray();
        IncreaseNumberShowJob::dispatch([
            "arr_id_vacancies"=>$idVacancies,
        ])->onQueue('default');

        $companyArr = $company->toArray();

        // 4 установить мета теги страницы
        $metaService->setMetaShowCompanyPage($companyArr);

        // 5 установить  meta Open Graph
        $config = config('site.open_graph');
        $config["title_page"] = __('meta_tags.show_company.title', [ "company"=>$companyArr["title"] ]);
        $config["description"] = __('meta_tags.show_company.description', [ "company"=>$companyArr["title"] ]);

        $metaService->setOpenGraph($config);

        // 7 установить meta Twitter Card
        $metaService->setTwitterCard($config);

        // 8 вернуть ссылки Sharing соц-сетей
        $settings["social_share"] = $this->getLinksShare();

        return view('company', compact('company','settings', 'contact_list'));
    }

    /**
     * проверка уникальности транслитерации title company
     * @param  CheckTransliterationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkTransliteration(CheckTransliterationRequest $request)
    {
        $cool = $this->repository->checkTransliteration($request->alias);
        return $this->getResponse($cool);
    }

    /**
     * настройки категорий и страны сайта
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getSettings(){
        $settings['categories'] = config('site.categories.categories');
        $settings['obj_countries'] = (new LocalizationService())->getCountries(App::getLocale());
        $settings['count_working'] = config('site.company.count_working');

        return $settings;
    }
}
