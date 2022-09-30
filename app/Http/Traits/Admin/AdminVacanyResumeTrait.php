<?php
namespace App\Http\Traits\Admin;

use Illuminate\Support\Carbon;

trait AdminVacanyResumeTrait
{

    /**
     * выборка фильтров
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function initialDataForSampling($request){
        $this->model = $this->userDocument($request);

        return $this->model;
    }

    /**
     * вакансии/resume юзера
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    private function userDocument($request){
        if (isset($request->user_id)) {
            $this->model = $this->model->where('user_id', $request->user_id);
        }

        return $this->model;
    }

    /**
     * настройки конфигураций
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getSettingsDocumentsAndCountries(){
        $settings = config('site.settings_vacancy');
        $settings['contact_information'] = config('site.contacts.contact_information');
        $settings['categories'] = config('site.categories.categories');

        return $settings;
    }

}
