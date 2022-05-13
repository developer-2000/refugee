<?php
namespace App\Http\Controllers;

use App\Model\MakeGeographyDb;

class PrivateOfficeController extends Controller
{

    public function index()
    {

        return view('private_office');
    }

    public function myCompany()
    {
        $settings = $this->getSettings();
        return view('company', compact('settings'));
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
