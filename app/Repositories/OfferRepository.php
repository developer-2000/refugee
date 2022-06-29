<?php
namespace App\Repositories;

use App\Http\Traits\DateTrait;
use App\Http\Traits\RespondTraite;
use App\Model\Offer as Model;
use App\Model\OfferChatArchive;
use App\Model\UserCompany;
use Illuminate\Support\Facades\Auth;

class OfferRepository extends CoreRepository {
    use RespondTraite, DateTrait;

    public function __construct() {
        $this->model = clone app(Model::class);

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

    public function show($offer_id) {
        $offer = $this->getChat($offer_id);

        // 1 отметить прочитанность чата
        $offer = $this->registerChatRead($offer);
        // 2 добавить обьект контактного листа
        $offer = $this->creatContactList(collect([$offer]))[0];
        // 3 добавить url компании на сайте
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
                'alias' => sha1(time())
            ]
        );
    }

    public function destroy($request) {
        $offer = $this->getByWithVerification($request);

        if(!is_null($offer) && isset($offer->chat[$request->index])){
            $chat = $offer->chat;
            array_splice($chat, $request->index, 1);
            $offer->chat = $chat;
            $offer->save();
        }

        return true;
    }

    public function sendToArchive($request) {
        $offer = $this->getByWithVerification($request);
        if(is_null($offer)){
            return [false, 'offer does not exist'];
        }

        $archive_offer = OfferChatArchive::create([
            "table_id"=>$offer->id,
            "one_user_id"=>$offer->one_user_id,
            "two_user_id"=>$offer->two_user_id,
            "chat"=>$offer->chat,
            "one_user_review"=>$offer->one_user_review,
            "two_user_review"=>$offer->two_user_review,
            "accepted"=>$offer->accepted,
            "alias"=>$offer->alias,
            "table_created_at"=>$offer->created_at,
            "table_updated_at"=>$offer->updated_at,
        ]);

        $offer->delete();

        return [true];
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
     * поиск среди имеющихся имен контакта и названий компании
     * @param $request
     * @return array
     */
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

    /**
     * добавить новое сообщение в чат
     * @param $request
     * @return mixed
     */
    public function addMessage($request) {
        $my_user = Auth::user();
        $offer = $this->getChat($request->offer_id);

        $message = config('site.offer.message');
        $message["user_id"] = $my_user->id;
        $message["date_create"] = $this->getNowDate();
        $message["covering_letter"] = $request->text;
        if(isset($request->important_message)){
            $message["important_message"] = 1;
        }

        // 2 обновить или создать offer chat
        $this->setDataOffer($offer, $message, $my_user->id);

        return $offer->chat[count($offer->chat)-1];
    }

    /**
     * отметить просмотр сообщений собеседника
     * @param $request
     * @return mixed
     */
    public function registerViewedCompanion($request) {
        // указаный чат по id с проверкой меня в нем
        $offer = $this->getByWithVerification($request);

        if($offer){
            $chat = $offer->chat;
            foreach ($chat as $key => $message){
                if($message['user_id'] !== Auth::user()->id){
                    $chat[$key]['your_viewing'] = 1;
                }
            }
            $offer->chat = $chat;
            $offer->save();
        }

        return true;
    }

    /**
     * отметить прочитанность чата (чтоб не отображать сообщения о новом сообщении)
     * @param $offer
     * @return mixed
     */
    public function registerChatRead($offer) {
        if($offer->one_user_id == Auth::user()->id){
            $offer->one_user_review = 1;
        }
        elseif($offer->two_user_id == Auth::user()->id){
            $offer->two_user_review = 1;
        }
        $offer->save();

        return $offer;
    }

    public function updateMessage($request) {
        // указаный чат по id с проверкой меня в нем
        $offer = $this->getByWithVerification($request);
        // есть ли индекс чата
        if(!is_null($offer) && isset($offer->chat[$request->index])){
            $chat = $offer->chat;
            // могу ли еще обновить
            if($chat[$request->index]['your_viewing'] === 0){
                $chat[$request->index]['covering_letter'] = $request->text;
                $offer->chat = $chat;
                $offer->save();
            }
            else{
                return [false, 'reload'];
            }
        }
        else{
            return [false, 'chat does not exist'];
        }

        return [true];
    }


    // PRIVATE
    /**
     * выбрать чат по id с данными контакта моего собеседника
     * @param $offer_id
     * @return mixed
     */
    private function getChat($offer_id)
    {
        $company = null;
        $my_id = Auth::user()->id;
        // 1 выбрать все мои чаты с контактами собеседника
        $offer = $this->model->where('id', $offer_id)
            ->with(["contact_one_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_one_user.position"])
            ->with(["contact_two_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_two_user.position"])
            ->first();

        return $offer;
    }

    /**
     * выбрать чат по id с проверкой меня в нем
     * @param $request
     * @return mixed
     */
    private function getByWithVerification($request)
    {
        $my_user = Auth::user();

        // указаный чат по id с проверкой меня в нем
        return $this->model->where(function($query) use ($request, $my_user) {
            $query->where(function ($query) use ($request, $my_user) {
                $query->where('id', $request->offer_id)
                    ->where('one_user_id', $my_user->id);
            })
                ->orWhere(function ($query) use ($request, $my_user) {
                    $query->where('id', $request->offer_id)
                        ->where('two_user_id', $my_user->id);
                });
        })->first();
    }

    /**
     * мои чаты с данными контакта моего собеседника
     * @return mixed
     */
    private function getMyChats()
    {
        $my_id = Auth::user()->id;
        // 2 выбрать все мои чаты с контактами собеседника
        $offers = $this->model->where('one_user_id', $my_id)
            ->orWhere('two_user_id', $my_id)
            ->with(["contact_one_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_one_user.position"])
            ->with(["contact_two_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_two_user.position"])
            ->orderByDesc('updated_at')
            ->get();

        $offers = $this->creatContactList($offers);

        return $offers;
    }

    /**
     * добавить обьект контактного листа
     * @param $offers
     * @return mixed
     */
    private function creatContactList($offers)
    {
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
