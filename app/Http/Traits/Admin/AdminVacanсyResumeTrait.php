<?php
namespace App\Http\Traits\Admin;

use Illuminate\Support\Carbon;

trait AdminVacanсyResumeTrait
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

    private function updateVerified($request, $model){
        $config = config("site.settings_vacancy");

        $arr = [
            'check_admin' => 1,
            'published' => $request->verified == 0 ? 0 : 1,
            'blocked' => $request->verified == 0 ? 1 : 0,
        ];

        if($request->verified == 0){
            $arr["job_posting"] = [
                // hidden
                'status_name'=> $config['job_status'][1],
                'create_time'=>now()->subDays($config["lifetime_days_job_status"]["standard"]),
            ];
        }
        else{
            $arr["job_posting"] = [
                // standard
                'status_name'=> $config['job_status'][0],
                'create_time'=>now(),
            ];
        }

        $model->where('id', $request->id)
            ->update($arr);
    }

}
