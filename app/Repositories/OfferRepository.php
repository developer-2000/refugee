<?php
namespace App\Repositories;

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

    public function index($request) {
        $arraySearch = [];
        // 1 мои чаты с обьектом контакта
        $offers = $this->getMyChats();

        // 2 если был поиск по названию или fullname
        if (isset($request->search)) {
            $arrSearch = explode(" ", $request->search);

            foreach ($offers as $key => $item){
                foreach ($arrSearch as $key2 => $str){

                    if(!is_null($item->contact_list['position'])){
                        if(strripos($item->contact_list['position'], $str) !== false){
                            $arraySearch[] = $item;
                            break;
                        }
                    }
                    if(!is_null($item->contact_list['full_name'])){
                        if(strripos($item->contact_list['full_name'], $str) !== false){


                            $arraySearch[] = $item;
                            break;
                        }
                    }

                }
            }
            $offers = $arraySearch;
        }

        return $offers;
    }

    public function searchNamePosition($request) {
        $arraySearch = [];
        $offers = $this->getMyChats();

        foreach ($offers as $key => $item){
            if(!is_null($item->contact_list['position'])){
                if(strripos($item->contact_list['position'], $request->value) !== false){
                    $arraySearch[] = $item->contact_list['position'];
                }
            }
            if(!is_null($item->contact_list['full_name'])){
                if(strripos($item->contact_list['full_name'], $request->value) !== false){
                    $arraySearch[] = $item->contact_list['full_name'];
                }
            }
        }

        return $arraySearch;
    }


    // PRIVATE
    /**
     * мои чаты с обьектом контакта
     * @return mixed
     */
    private function getMyChats()
    {
        $my_id = Auth::user()->id;
        // 2 выбрать все мои чаты с контактами собеседника
        $offers = $this->model->where('one_user_id', Auth::user()->id)
            ->orWhere('two_user_id', Auth::user()->id)
            ->with(["contact_one_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_one_user.position"])
            ->with(["contact_two_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_two_user.position"])
            ->orderByDesc('updated_at')
            ->get();

        $offers->each(function ($item, $key) {
            if(!is_null($item->contact_one_user)){
                $item->contact_list = (new ContactInformationRepository())->fillContactList(
                    $item->contact_one_user, $item->contact_one_user->user_id
                );
            }
            elseif(!is_null($item->contact_two_user)){
                $item->contact_list = (new ContactInformationRepository())->fillContactList(
                    $item->contact_two_user, $item->contact_two_user->user_id
                );
            }
        });

        return $offers;
    }
}
