<?php
namespace App\Http\Controllers\Admin\Documents;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Vacancies\VerifiedByAdminRequest;
use App\Http\Traits\GeneralVacancyResumeTraite;
use App\Http\Traits\Geography\GeographyForShowInterfaceTraite;
use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Model\Vacancy;
use App\Services\LocalizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class AdminVacanciesController extends AdminBaseController {
    use GeographyForShowInterfaceTraite;
//    public function __construct() {
//        parent::__construct();
//    }

    public function index(){
        $vacancies = Vacancy::with("position",'country','region','city')
            ->paginate(2);

        // 3 address
        foreach ($vacancies as $key => $vacancy){
            $vacancy = $this->addPropertiesToCollection($vacancy);
            $vacancy = collect($vacancy);
            $vacancies[$key] = $vacancy->except(['city','region','country']);
        }

        $settings = $this->getSettingsDocumentsAndCountries();
        $settings['contact_information'] = config('site.contacts.contact_information');

        $response = [
            "vacancies"=>$vacancies,
            "settings"=>$settings,
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

    public function verifiedByAdmin(VerifiedByAdminRequest $request){
        Vacancy::where('id', $request->vacancy_id)
            ->update([
                'check_admin' => 1,
                'published' => $request->verified,
            ]);

        return $this->getResponse();
    }

    private function getSettingsDocumentsAndCountries(){
        $settings = config('site.settings_vacancy');
        $settings = array_merge($settings, config('site.search_title_panel.collection_location'));
        $settings['start_search_page'] = config('site.search_title_panel.start_search_page');
        $settings['obj_countries'] = (new LocalizationService())->getCountries(App::getLocale());
        $settings['categories'] = config('site.categories.categories');

        return $settings;
    }
}
