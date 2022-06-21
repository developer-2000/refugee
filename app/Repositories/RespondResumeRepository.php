<?php
namespace App\Repositories;

use App\Model\RespondResume as Model;
use App\Model\UserResume;
use App\Model\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RespondResumeRepository extends CoreRepository {

    public function __construct() {
        $this->model = clone app(Model::class);
    }

    /**
     * откликнуться на резюме
     * @param $request
     * @return mixed|null
     */
    public function respondResume($request) {
        $offerRepository = new OfferRepository();
        $my_user = Auth::user();
        $resume = UserResume::where('id',$request->resume_id)
            ->with('position')->first();
        $vacancy = Vacancy::where('id',$request->vacancy_id)
            ->with('position')->first();

        // 1 фиксация отзыва
        $respond = $this->model->create(
            [
                'resume_id' => $request->resume_id,
                'vacancy_id' => $request->vacancy_id,
                'user_resume_id' => $resume->user_id,
                'user_vacancy_id' => $my_user->id
            ]
        );

        $message = [
            "my_offer_title"=>$vacancy->position->title,
            "my_offer_url"=>"vacancy/$vacancy->alias",
            "your_offer_title"=>$resume->position->title,
            "your_offer_url"=>"resume/$resume->alias",
            "covering_letter"=>$request->textarea_letter,
        ];

        // вернет существующий чат с контактом
        $offer = $offerRepository->getOffer($resume->user_id, $my_user->id);

        // 2.1 обновить существующий
        if($offer){
            $chat = $offer->chat;
            $chat[] = $message;
            $offer->chat = $chat;
            $offer->save();
        }
        // 2.2 создать новый
        else{
            $chat = $offerRepository->create($my_user->id, $resume->user_id, $message);
        }

    }

    /**
     * вернет количество не прочтанных откликов на мои резюме
     * @param  UserResume  $resume
     * @return int
     */
    public function getCountRespondResumes(ResumeRepository $resume) {
        $count = 0;
        if($resumes = $resume->getMyResumes(Auth::user())){
            $arrIdResumes = $resumes->pluck('id');
            $count = $this->model->whereIn('resume_id',$arrIdResumes)
                ->where('review',0)->count();
        }

        return $count;
    }

}
