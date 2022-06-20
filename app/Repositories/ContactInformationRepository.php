<?php
namespace App\Repositories;

use App\Http\Traits\LoadFileMethodsTraite;
use App\Model\Image;
use App\Model\Position;
use App\Model\RespondResume;
use App\Model\RespondVacancy;
use App\Model\Test;
use App\Model\UserContact;
use App\Model\UserContact as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactInformationRepository extends CoreRepository {
    use LoadFileMethodsTraite;

    protected $settings;
    protected $path_avatar;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->path_avatar = '/img/avatars/contacts/';
    }

    public function updateContact($request){
        // проверка
        if(!$contact = UserContact::where('id', $request->contact_id)
            ->where('user_id', Auth::user()->id)->first() ){
            return true;
        }

        $arr = $this->makeArrayContact($request);

        // 1 удалить старое название, если оно не будет никем использоватся
        $this->deleteUnwantedTitle($request, $contact->position_id);
        // 2 выбрать или создать название
        if(!is_null($request->position)){
            $position = Position::firstOrCreate(
                ['title' => mb_strtolower($request->position, 'UTF-8')]
            );
            $arr['position_id'] = $position->id;
        }
        else{
            $arr['position_id'] = null;
        }

        // с фронта пришел image
        if(!is_null($request->image)){
            // 1 существует avatar у юзера
            if(!is_null($contact->avatar_id)){
                $coll = Image::find($contact->avatar_id);
                // удалить физически
                $this->deletePhysically($coll->url);
            }
            // 2 сохранить file
            $image = json_decode($request->image);
            $path = $this->savePhysically(
                $image,
                $this->path_avatar.date('m-Y'),
                $image->name
            );
            // сохранить данные картинки в базу
            $arr['avatar_id'] = $this->saveImageDataToDatabase($path, $contact->avatar_id, 1);
        }

        return $this->model->where('id', $request->contact_id)
            ->where('user_id', Auth::user()->id)
            ->update($arr);
    }

    private function makeArrayContact($request){
        return [
            'name'=>$request->name,
            'surname'=>$request->surname,
            'email'=>$request->email,
            'skype'=>$request->skype,
            'phone'=>$request->phone,
            'messengers'=>!is_null($request->messengers) ? array_map('intval', $request->messengers) : [],
        ];
    }

    // заполнить контакт просматриваемого юзера
    public function fillContactList($coll){
        $my_user = Auth::user();
        $contact_list = config('site.contacts.contact_list');
        $contact_list['avatar_url'] = !is_null($coll->contact->avatar) ? $coll->contact->avatar->url : $coll->contact->default_avatar_url;
        $contact_list['full_name'] = $coll->contact->name." ".$coll->contact->surname;
        $contact_list['position'] = !is_null($coll->contact->position) ? $coll->contact->position->title : null;

        // я авторизован
        if($my_user){
            $contact_list['access']['auth'] = true;

            // если между сторонами в какомто из respond было принятие
            $received = RespondResume::where('user_resume_id', $coll->user_id)
                ->where('user_vacancy_id',$my_user->id)
                ->where('accepted',1)
                ->first();
            if(!$received){
                $received = RespondVacancy::where('user_resume_id', $my_user->id)
                    ->where('user_vacancy_id',$coll->user_id)
                    ->where('accepted',1)
                    ->first();
            }

            // владелец документа принят мой respond
            if($received){
                $contact_list['access']['received_respond'] = true;
                $contact_list['email'] = $coll->contact->email;
                $contact_list['skype'] = $coll->contact->skype;
                $contact_list['phone'] = [
                    "phone" => $coll->contact->phone,
                    "messengers" => $coll->contact->messengers,
                ];
            }
        }

        return $contact_list;
    }
}
