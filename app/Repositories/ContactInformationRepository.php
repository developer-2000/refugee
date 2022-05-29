<?php
namespace App\Repositories;

use App\Http\Traits\CountPositionTraite;
use App\Model\Position;
use App\Model\UserContact;
use App\Model\UserContact as Model;
use Illuminate\Support\Facades\Auth;


class ContactInformationRepository extends CoreRepository {
    use CountPositionTraite;

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
    }

    /**
     * Создать контакт данные для user
     * @param $request
     * @return bool
     */
    public function storeContact($request){
        // защита от повтора
        if(UserContact::where('user_id', Auth::user()->id)->first()){
            return true;
        }

        $arr = $this->makeArrayContact($request);
        $arr['user_id'] = Auth::user()->id;

        if($request->position != ''){
            $position = Position::firstOrCreate(
                ['title' => mb_strtolower($request->position, 'UTF-8')]
            );
            $arr['position_id'] = $position->id;
        }

        return $this->model->create($arr);
    }

    public function updateContact($request){
        // проверка
        if(!$contact = UserContact::where('id', $request->contact_id)
            ->where('user_id', Auth::user()->id)->first() ){
            return true;
        }

        $arr = $this->makeArrayContact($request);

        // удалить старое название, если оно не будет никем использоватся
        $this->deleteUnwantedVacancyTitle($request, $contact->position_id);
        if($request->position != ''){
            $position = Position::firstOrCreate(
                ['title' => mb_strtolower($request->position, 'UTF-8')]
            );
            $arr['position_id'] = $position->id;
        }
        else{
            $arr['position_id'] = null;
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
            'messengers'=>array_map('intval', $request->messengers),
        ];
    }
}
