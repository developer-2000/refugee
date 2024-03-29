<?php
namespace App\Http\Traits;

use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Model\GeographyDb;
use App\Model\Position;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait RespondTraite {

    // обновить или создать offer chat
    public function setDataOffer($offer, $message, $my_id, $user_id=null, $my_document_title=null)
    {
        // 1 обновить существующий
        // обновить чат могу в тех случаях если собеседник быстрей меня создал наш чат
        // или это предложение вношу в старый чат других предложений
        if($offer){

            $chat = $offer->chat;
            // 1,1 добавить новый контент
            $chat[] = $message;

            // в случае предложения документа
            if(!is_null($my_document_title)){
                // 1,2 заменить название чата
                $chat[0]["title_chat"] = $my_document_title;
            }

            $offer->chat = $chat;

            if($offer->one_user_id == $my_id){
                // 1,3,1 у собеседника отобразит сигнал - новое сообщение
                $offer->two_user_review = 0;
            }
            elseif ($offer->two_user_id == $my_id){
                $offer->one_user_review = 0;
                // 1,3,2 открываю контакты так как two_user это человек которого преглашали в чат
                $offer->accepted = 1;
            }

            $offer->save();
        }
        // 2 создать новый
        else{
            // 2,1 установить название чата
            $message["title_chat"] = $my_document_title;
            $chat = $this->offerRepository->create($my_id, $user_id, $message);
        }
    }

    /**
     * создает полный путь для resume / vacancy
     * @param $collection
     * @param $prefix
     * @return string
     */
    private function makeFullUrlForDocument($collection, $prefix){
        $address_first_prefix = !is_null($collection->country) ? $collection->country->local['original_index'] : "";
        $address_next_prefix = !is_null($collection->city) ? $collection->city->local['original_index'] :
            (!is_null($collection->region) ? $collection->region->local['original_index'] : "");

        return $prefix."/".$address_first_prefix."/".$address_next_prefix."/".$collection->alias;
    }
}
