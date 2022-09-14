<?php
namespace App\Repositories;

use App\Http\Traits\DateTrait;
use App\Http\Traits\OfferAndArchiveTrait;
use App\Http\Traits\RespondTraite;
use App\Jobs\ChatMessageJob;
use App\Model\Offer;
use App\Model\OfferChatArchive as Model;
use App\Model\User;
use App\Model\UserCompany;
use Illuminate\Support\Facades\Auth;

class OfferArchiveRepository extends CoreRepository {
    use RespondTraite, DateTrait, OfferAndArchiveTrait;

    public function __construct() {
        $this->model = clone app(Model::class);
    }

    public function index($request) {
        // 1 мои чаты с обьектом контакта
        $offers = $this->getMyChats();
        // 2 если был поиск по названию или fullname
        $offers = $this->indexFilter($request, $offers);

        return $offers;
    }

    public function show($offer_id) {
        $offer = $this->getChat('alias', $offer_id);
        // 1 добавить обьект контактного листа
        $offer = $this->creatContactList(collect([$offer]))[0];
        // 2 добавить url компании на сайте
        if(!is_null($offer->contact_one_user)){
            $company = UserCompany::where('user_id',$offer->contact_one_user->user_id)->first();
        }
        else{
            $company = UserCompany::where('user_id',$offer->contact_two_user->user_id)->first();
        }
        $offer->url_company = !is_null($company) ? $company->alias : null;

        return $offer;
    }

    /**
     * переместить в таблицу предложения и добавить новое сообщение в чат
     * @param $request
     * @return mixed
     */
    public function addMessage($request) {
        $my_user = Auth::user();
        // 1 переместить из архива в offer
        $offer = $this->sendToOffer($request);
        // чат не в архиве
        if(is_null($offer)){
            return [false, 'Offer does not exist'];
        }

        $message = config('site.offer.message');
        $message["user_id"] = $my_user->id;
        $message["date_create"] = $this->getNowDate();
        $message["covering_letter"] = $request->text;
        if(isset($request->important_message)){
            $message["important_message"] = 1;
        }

        // 2 обновить или создать offer chat
        $this->setDataOffer($offer, $message, $my_user->id);

        // 3 отправка Email
        $this->sendEmail($offer, $my_user, $message);

        return $offer->chat[count($offer->chat)-1];
    }

    /**
     * выбрать чат двух участников
     * @param $user_id
     * @param $my_id
     * @return mixed
     */
    public function getOurChat($user_id, $my_id)
    {
        return $this->model->where(function($query) use ($user_id, $my_id) {
            $query->where(function ($query) use ($user_id, $my_id) {
                $query->where('one_user_id', $user_id)
                    ->where('two_user_id', $my_id);
            })
                ->orWhere(function ($query) use ($user_id, $my_id) {
                    $query->where('one_user_id', $my_id)
                        ->where('two_user_id', $user_id);
                });
        })->first();
    }

    private function sendToOffer($request) {
        $archive = $this->getChat('table_id', $request->offer_id);
        if(is_null($archive)){
            return null;
        }

        $offer = Offer::create([
            "id"=>$archive->table_id,
            "one_user_id"=>$archive->one_user_id,
            "two_user_id"=>$archive->two_user_id,
            "chat"=>$archive->chat,
            "one_user_review"=>$archive->one_user_review,
            "two_user_review"=>$archive->two_user_review,
            "accepted"=>$archive->accepted,
            "alias"=>$archive->alias,
            "created_at"=>$archive->table_created_at,
            "updated_at"=>$archive->table_updated_at,
        ]);

        if($offer){
            $archive->delete();
        }

        return $offer;
    }
}
