<?php

namespace App\Http\Controllers;

use App\Model\UserCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function show($alias){
        $company = UserCompany::where('alias', $alias)
            ->with(
                'image',
                'vacancies.position',
                'vacancies.company.image',
                'vacancies.id_saved_vacancies',
                'vacancies.id_not_shown_vacancies',
                'contact'
            )->firstOrFail();
        $settings = config('site.settings_vacancy');
        $settings['categories'] = config('site.categories.categories');
        $settings['count_working'] = config('site.company.count_working');
        $settings['contact_information'] = config('site.contacts.contact_information');

        return view('company', compact('company','settings'));
    }



}
