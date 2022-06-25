<?php
namespace App\Repositories;

use App\Http\Traits\DateTrait;
use App\Http\Traits\RespondTraite;
use App\Model\RespondVacancy as Model;
use App\Model\UserResume;
use App\Model\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RespondVacancyRepository extends CoreRepository {
    use RespondTraite, DateTrait;

    protected $settings;
    protected $path_to_file;
    protected $offerRepository;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->path_to_file = "/files/resumes/";
        $this->offerRepository = new OfferRepository();
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
     * создать запись в базе respond
     * @param $request
     * @param $resume_id
     * @return mixed
     */
    private function createRecordDatabase($request, $resume_id){
        $my_user = Auth::user();
        // вакансия человека
        $vacancy = Vacancy::where('id',$request->vacancy_id)
            ->with('position')->first();
        // мое резюме
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

        // вернет указаный чат по id - мой и юзер
        $offer = $this->offerRepository->getOffer($vacancy->user_id, $my_user->id);

        $message = config('site.offer.message');
        $message["user_id"] = $my_user->id;
        $message["date_create"] = $this->getNowDate();
        $message["my_type_document"] = 'resume';
        $message["your_type_document"] = 'vacancy';
        $message["my_offer_title"] = $resume->position->title;
        $message["my_offer_url"] = "resume/$resume->alias";
        $message["your_offer_title"] = $vacancy->position->title;
        $message["your_offer_url"] = "vacancy/$vacancy->alias";
        $message["covering_letter"] = $request->textarea_letter;

        // 2 обновить или создать offer chat
        $this->setDataOffer($offer, $message, $my_user->id, $vacancy->user_id, $resume->position->title);

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
