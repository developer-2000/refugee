<?php
namespace App\Http\Traits;

use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Model\MakeGeographyDb;
use App\Model\Position;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait RespondTraite {


//обновить или создать offer chat
    public function setDataOffer($offer, $user_id, $my_id, $message, $my_document_title)
    {
        // 1 обновить существующий
        // обновить чат могу в тех случаях если собеседник быстрей меня создал наш чат
        // или это предложение вношу в старый чат других предложений
        if($offer){
            $chat = $offer->chat;
            // 1,1 добавить новый контент
            $chat[] = $message;
            // 1,2 заменить название чата
            $chat[0]["title_chat"] = $my_document_title;
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

}
