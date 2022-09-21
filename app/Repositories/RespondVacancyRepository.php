<?php
namespace App\Repositories;

use App\Http\Traits\DateTrait;
use App\Http\Traits\RespondTraite;
use App\Jobs\RespondVacancyResumeJob;
use App\Model\RespondVacancy as Model;
use App\Model\Resume;
use App\Model\User;
use App\Model\Vacancy;
use App\Services\StatisticVacanciesService;
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
                $resume = Resume::updateOrCreate(
                    [ 'user_id' => Auth::user()->id, 'type' => 1 ],
                    [
                        'title' => $arrUrl[count($arrUrl)-1],
                        'url' => $path,
                        'alias' => sha1(time())
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
        $statisticService = new StatisticVacanciesService();

        // вакансия человека
        $vacancy = Vacancy::where('id',$request->vacancy_id)
            ->with('position','country','region','city')->first();
        // мое резюме
        $resume = Resume::where('id',$resume_id)
            ->with('position','country','region','city')->first();

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
        $resume_title = $resume->type === 0 ? $resume->position->title : $resume->title;
        $offer_url = $resume->type === 0 ? $this->makeFullUrlForDocument($resume, "resume") : $resume->url;

        // 2 обновить или создать offer chat
        $message = config('site.offer.message');
        $message["user_id"] = $my_user->id;
        $message["date_create"] = $this->getNowDate();
        $message["my_type_document"] = 'resume';
        $message["your_type_document"] = 'vacancy';
        $message["my_offer_title"] = !is_null($resume->position) ? $resume->position->title : $resume->title;
        $message["my_offer_url"] = $offer_url;
        $message["your_offer_title"] = $vacancy->position->title;
        $message["your_offer_url"] = $this->makeFullUrlForDocument($vacancy, "vacancy");
        $message["covering_letter"] = $request->textarea_letter;

        $this->setDataOffer($offer, $message, $my_user->id, $vacancy->user_id, $resume_title);

        // 3 увеличить кол-во откликов
        $statisticService->increaseNumberRespond($request->vacancy_id);

        // 4 отправка Email
        $offer = $this->offerRepository->getOffer($vacancy->user_id, $my_user->id);

        $toUserData = User::where("id",$vacancy->user_id)->with("contact")->first();
        $email_respond = $toUserData->contact->email;
        if(is_null($email_respond)){
            $email_respond = $toUserData->email;
        }

        RespondVacancyResumeJob::dispatch([
            "email_respond"=>$email_respond,                                  // кому отправить
            "full_name_person_write"=>$my_user->contact->full_name,           // от кого письмо
            "chat_title"=>$offer->chat[0]['title_chat'],                      // название чата
            "chat_link"=>session('prefix_lang')."offers/".$offer->alias, // ссылка чата
            "offer_document_title"=>$message['my_offer_title'],               // название документа
            // если документ сайта или .doc                                   // ссылка документа
            "offer_document_link"=> (strripos($message['my_offer_url'], 'files') !== false) ?
                "/".$message['my_offer_url'] : session('prefix_lang').$message['my_offer_url'],
            "chat_text"=>$message['covering_letter'],                         // сообщение чата
        ])->onQueue('emails');

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
        if( $resume = Resume::where('user_id', Auth::user()->id)->where('type', 1)->first() ){
            $arrUrl = explode("/", $resume->url);
            array_pop($arrUrl);
            $url = implode("/", $arrUrl);

            if (Storage::disk('app_public')->has($url)){
                Storage::disk('app_public')->deleteDirectory($url);
            }
        }
    }

}
