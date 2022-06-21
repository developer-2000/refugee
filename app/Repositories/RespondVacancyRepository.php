<?php
namespace App\Repositories;

use App\Model\Offer;
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
        $offerRepository = new OfferRepository();
        $my_user = Auth::user();
        $vacancy = Vacancy::where('id',$request->vacancy_id)
            ->with('position')->first();

        $resume = UserResume::where('id',$resume_id)
            ->with('position')->first();

        // 1 фиксация отзыва
        $respond = $this->model->create(
            [
                'vacancy_id' => $request->vacancy_id,
                'resume_id' => $resume_id,
                'user_resume_id' => $my_user->id,
                'user_vacancy_id' => $vacancy->user_id
            ]
        );

        $message = [
            "my_offer_title"=>$resume->position->title,
            "my_offer_url"=>"resume/$resume->alias",
            "your_offer_title"=>$vacancy->position->title,
            "your_offer_url"=>"vacancy/$vacancy->alias",
            "covering_letter"=>$request->textarea_letter,
        ];

        // вернет существующий чат с контактом
        $offer = $offerRepository->getOffer($vacancy->user_id, $my_user->id);

        // 2.1 обновить существующий
        if($offer){
            $chat = $offer->chat;
            $chat[] = $message;
            $offer->chat = $chat;
            $offer->save();
        }
        // 2.2 создать новый
        else{
            $chat = $offerRepository->create($my_user->id, $vacancy->user_id, $message);
        }

        return $respond;
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
