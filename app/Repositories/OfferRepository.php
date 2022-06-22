<?php
namespace App\Repositories;

use App\Model\Offer;
use App\Model\Offer as Model;
use Illuminate\Support\Facades\Auth;

class OfferRepository extends CoreRepository {

    public function __construct() {
        $this->model = clone app(Model::class);

    }

    /**
     * вернет указаный чат по id - мой и юзер
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


    public function getIndexPage() {
        $offers = $this->model->where('one_user_id', Auth::user()->id)
            ->orWhere('two_user_id', Auth::user()->id)
            ->get();
    }

    /**
     * создать первое сообщение с откликом на документ
     * @param $my_id
     * @param $user_id
     * @param $message
     * @return mixed
     */
    public function create($my_id, $user_id, $message) {
        return $this->model->create(
            [
                'one_user_id' => $my_id,
                'two_user_id' => $user_id,
                'one_user_review' => 1,
                'chat' => [$message],
            ]
        );
    }

    /**
     * проверка открытости контактов в чате
     * @param $user_id
     * @param $my_user
     * @return mixed
     */
    public function checkOpenContactsInChat($user_id, $my_id) {
        return $this->model->where(function($query) use ($user_id, $my_id) {
            $query
                ->where( function ($query) use ($user_id, $my_id) {
                    $query->where('one_user_id', $user_id)->where('two_user_id',$my_id)->where('accepted',1);
                })
                ->orWhere(function ($query) use ($user_id, $my_id) {
                    $query->where('one_user_id', $my_id)->where('two_user_id',$user_id)->where('accepted',1);
                });
        })->first();
    }

    /**
     * вернуть количество не прочитанных чатов
     * @return mixed
     */
    public function getCountUnreadChats() {
        $my_id = !is_null(Auth::user()) ? Auth::user()->id : null;
        if(!is_null($my_id)){
            return $this->model->where(function($query) use ($my_id) {
                $query
                    ->where( function ($query) use ($my_id) {
                        $query->where('one_user_id', $my_id)->where('one_user_review', 0);
                    })
                    ->orWhere(function ($query) use ($my_id) {
                        $query->where('two_user_id', $my_id)->where('two_user_review', 0);
                    });
            })->count();
        }

        return 0;
    }


}
