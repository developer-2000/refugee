<?php
namespace App\Http\Controllers\Admin\Documents;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Vacancies\IndexVacancyAdminRequest;
use App\Http\Requests\Admin\Vacancies\VerifiedByAdminRequest;
use App\Http\Traits\Admin\AdminVacanсyResumeTrait;
use App\Http\Traits\Geography\GeographyForShowInterfaceTraite;
use App\Model\Vacancy;
use App\Model\Vacancy as Model;
use Illuminate\Http\Request;


class AdminVacanciesController extends AdminBaseController {
    use GeographyForShowInterfaceTraite, AdminVacanсyResumeTrait;

    protected $model;

    public function __construct() {
        parent::__construct();
        $this->model = clone app(Model::class);
    }

    public function index(IndexVacancyAdminRequest $request){
        $config = config('admin.page');

        // 1 фильтр выборки
        $vacancies = $this->initialDataForSampling($request);

        $vacancies = $vacancies->with("position", "statistic", 'country','region','city')
            ->paginate($config["paginate"]);

        // 3 address
        foreach ($vacancies as $key => $vacancy){
            $vacancy = $this->addPropertiesToCollection($vacancy);
            $vacancy = collect($vacancy);
            $vacancies[$key] = $vacancy->except(['city','region','country']);
        }

        $settings = $this->getSettingsDocumentsAndCountries();


        $response = [
            "vacancies"=>$vacancies,
            "settings"=>$settings,
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    /**
     * проверка админом
     * @param  VerifiedByAdminRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifiedByAdmin(VerifiedByAdminRequest $request){
        $this->updateVerified($request, new Vacancy());

        return $this->getResponse();
    }

}
