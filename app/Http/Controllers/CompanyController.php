<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CheckTransliterationRequest;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Model\MakeGeographyDb;
use App\Model\UserCompany;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends BaseController {

    protected $repository;

    public function __construct() {
//        parent::__construct();
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
            ->with('image')->first();

        return view('my_company', compact('company','settings'));
    }

    /**
     * создание своей компании
     * @param  StoreCompanyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCompanyRequest $request)
    {
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
        $company = UserCompany::where('alias', $alias)
            ->with(
                'image',
                'vacancies.position',
                'vacancies.company.image',
                'vacancies.id_saved_vacancies',
                'vacancies.id_hide_vacancies',
                'contact'
            )->firstOrFail();
        $settings = config('site.settings_vacancy');
        $settings['categories'] = config('site.categories.categories');
        $settings['count_working'] = config('site.company.count_working');
        $settings['contact_information'] = config('site.contacts.contact_information');

        return view('company', compact('company','settings'));
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
        if($objCountries = MakeGeographyDb::where('id', 1)->select('country')->first()){
            $settings['obj_countries'] = $objCountries['country']['EN'];
        }
        $settings['count_working'] = config('site.company.count_working');

        return $settings;
    }
}
