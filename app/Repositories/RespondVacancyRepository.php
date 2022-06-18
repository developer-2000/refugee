<?php
namespace App\Repositories;

use App\Model\RespondVacancy as Model;
use App\Model\UserResume;
use App\Model\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RespondVacancyRepository extends CoreRepository {

    protected $settings;
    protected $path_to_file;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->path_to_file = "/files/resumes/";
    }

    /**
     * откликнуться на вакансию
     * запись в базе respond
     * запись в базе resume
     * сохранение file resume
     *
     * @param $request
     * @return mixed|null
     */
    public function respondVacancy($request) {
        $respond = null;

        // 1 вкладка резюме на сайте
        if($request->bool_tab){
            $respond = $this->createRecordDatabase($request, $request->resume_id);
        }
        // вкладка файла резюме
        else{
            // 2 пришел новый файл
            if(!is_null($request->new_file)){
                // delete старый file c hdd
                $this->deleteFile();
                // сохранить file на hdd
                $path = $this->saveFile($request);
                $arrUrl = explode("/", $path);
                // создать запись резюме в базе
                $resume = UserResume::updateOrCreate(
                    [ 'user_id' => Auth::user()->id, 'type' => 1 ],
                    [
                        'title' => $arrUrl[count($arrUrl)-1],
                        'url' => $path
                    ]
                );
                $respond = $this->createRecordDatabase($request, $resume->id);
            }
            // 3 старый файл к вакансии
            else {
                $respond = $this->createRecordDatabase($request, $request->old_file_id);
            }
        }

        return $respond;
    }

    /**
     * вернет количество не прочтанных откликов на мои вакансии
     * @param  VacancyRepository  $vacancy
     * @return int
     */
    public function getCountRespondVacancies(VacancyRepository $vacancy) {
        $count = 0;
        if($vacancies = $vacancy->getMyVacancies(Auth::user())){
            $arrIdVacancies = $vacancies->pluck('id');
            $count = $this->model->whereIn('vacancy_id',$arrIdVacancies)
                ->where('review',0)->count();
        }

        return $count;
    }

    /**
     * создать запись в базе respond
     * @param $request
     * @param $resume_id
     * @return mixed
     */
    private function createRecordDatabase($request, $resume_id){
        $user_vacancy_id = Vacancy::where('id',$request->vacancy_id)
            ->first()->pluck('user_id');

        return $this->model->updateOrCreate(
            [
                'vacancy_id' => $request->vacancy_id,
                'user_resume_id' => Auth::user()->id
            ],
            [
                'user_vacancy_id' => $user_vacancy_id[0],
                'resume_id' => $resume_id,
                'textarea_letter' => $request->textarea_letter
            ]
        );
    }

    /**
     * сохранить file на hdd
     * @param $request
     * @return string
     */
    private function saveFile($request){
        // url каталога
        $path = $this->path_to_file.date('m-Y').'/'.(string)(microtime(true)*10000);
        $file = $request->new_file->getClientOriginalName();
        $filename = mb_strtolower(pathinfo($file, PATHINFO_FILENAME));
        $extension = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION));
        // имя файла
        $name = $filename.'.'.$extension;
        $path = Storage::disk('app_public')->putFileAs( $path, $request->new_file, $name);

        return $path;
    }

    /**
     * delete папку файла c hdd
     */
    private function deleteFile(){
        if( $resume = UserResume::where('user_id', Auth::user()->id)->where('type', 1)->first() ){
            $arrUrl = explode("/", $resume->url);
            array_pop($arrUrl);
            $url = implode("/", $arrUrl);

            if (Storage::disk('app_public')->has($url)){
                Storage::disk('app_public')->deleteDirectory($url);
            }
        }
    }
}
