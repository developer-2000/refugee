<?php
namespace App\Http\Controllers\Admin\Documents;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Vacancies\IndexVacancyAdminRequest;
use App\Http\Requests\Admin\Vacancies\VerifiedByAdminRequest;
use App\Http\Traits\Admin\AdminVacanyResumeTrait;
use App\Http\Traits\Geography\GeographyForShowInterfaceTraite;
use App\Model\Resume;
use App\Model\Resume as Model;
use Illuminate\Http\Request;


class AdminResumesController extends AdminBaseController {
    use GeographyForShowInterfaceTraite, AdminVacanyResumeTrait;

    protected $model;

    public function __construct() {
        parent::__construct();
        $this->model = clone app(Model::class);
    }

    public function index(IndexVacancyAdminRequest $request){
        $config = config('admin.page');

        // 1 фильтр выборки
        $resumes = $this->initialDataForSampling($request);

        $resumes = $resumes->with("position", "statistic", 'country','region','city')
            ->paginate($config["paginate"]);

        // 3 address
        foreach ($resumes as $key => $vacancy){
            $vacancy = $this->addPropertiesToCollection($vacancy);
            $vacancy = collect($vacancy);
            $resumes[$key] = $vacancy->except(['city','region','country']);
        }

        $settings = $this->getSettingsDocumentsAndCountries();

        $response = [
            "resumes"=>$resumes,
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
        Resume::where('id', $request->id)
            ->update([
                'check_admin' => 1,
                'published' => $request->verified,
            ]);

        return $this->getResponse();
    }

}
