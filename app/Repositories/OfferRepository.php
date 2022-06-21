<?php
namespace App\Repositories;

use App\Model\Offer as Model;
use Illuminate\Support\Facades\Auth;

class OfferRepository extends CoreRepository {

    public function __construct() {
        $this->model = clone app(Model::class);

    }

    /**
     * вернет указаный чат с контактом
     * @param $user_id
     * @param $my_id
     * @return mixed
     */
    public function getOffer($user_id, $my_id) {
        return $this->model->where(function($query) use ($user_id, $my_id) {
            $query
                ->where( function ($query) use ($user_id, $my_id) {
                    $query->where('one_user_id', $user_id)->where('two_user_id',$my_id);
                })
                ->orWhere(function ($query) use ($user_id, $my_id) {
                    $query->where('one_user_id', $my_id)->where('two_user_id',$user_id);
                });
        })->first();
    }

    /**
     * все мои чаты
     * @return mixed
     */
    public function getMyOffers() {
        return $this->model->where('one_user_id', Auth::user()->id)
            ->orWhere('two_user_id', Auth::user()->id)
            ->get();
    }

    // создать первое сообщение с откликом на документ
    public function create($user_id, $my_id, $message) {
        return $this->model->create(
            [
                'one_user_id' => $my_id,
                'two_user_id' => $user_id,
                'one_user_review' => 1,
                'chat' => [$message],
            ]
        );
    }

//`one_user_id`, `two_user_id`, `chat`, `one_user_review`, `two_user_review`, `accepted`

}