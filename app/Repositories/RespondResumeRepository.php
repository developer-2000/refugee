<?php
namespace App\Repositories;

use App\Http\Traits\DateTrait;
use App\Http\Traits\RespondTraite;
use App\Model\RespondResume as Model;
use App\Model\UserResume;
use App\Model\Vacancy;
use Illuminate\Support\Facades\Auth;

class RespondResumeRepository extends CoreRepository {
    use RespondTraite, DateTrait;

    protected $offerRepository;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->offerRepository = new OfferRepository();
    }

    /**
     * откликнуться на резюме
     * @param $request
     * @return mixed|null
     */
    public function respondResume($request) {
        $offerRepository = new OfferRepository();
        $my_user = Auth::user();

        // резюме человека
        $resume = UserResume::where('id',$request->resume_id)
            ->with('position','country','region','city')->first();
        // моя вакансия
        $vacancy = Vacancy::where('id',$request->vacancy_id)
            ->with('position','country','region','city')->first();

        // 1 фиксация отзыва
        $respond = $this->model->create(
            [
                'resume_id' => $request->resume_id,
                'vacancy_id' => $request->vacancy_id,
                'user_resume_id' => $resume->user_id,
                'user_vacancy_id' => $my_user->id
            ]
        );

        // вернет существующий чат с контактом
        $offer = $offerRepository->getOffer($resume->user_id, $my_user->id);
        $resume_url = $resume->type === 0 ? $this->makeFullUrlForDocument($resume, "resume") : $resume->url;
        $vacancy_url = $this->makeFullUrlForDocument($vacancy, "vacancy");

        $message = config('site.offer.message');
        $message["user_id"] = $my_user->id;
        $message["date_create"] = $this->getNowDate();
        $message["my_type_document"] = 'vacancy';
        $message["your_type_document"] = 'resume';
        $message["my_offer_title"] = $vacancy->position->title;


        $message["my_offer_url"] = $vacancy_url;
        $message["your_offer_title"] = $resume->position->title;


        $message["your_offer_url"] = $resume_url;
        $message["covering_letter"] = $request->textarea_letter;

        // 2 обновить или создать offer chat
        $this->setDataOffer($offer, $message, $my_user->id, $resume->user_id, $vacancy->position->title);

        return $respond;
    }

}
