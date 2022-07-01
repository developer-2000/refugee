<?php
namespace App\Http\Traits;

use App\Repositories\ContactInformationRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait OfferAndArchiveTrait
{

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

    /**
     * если был поиск по должности или fullname
     * @param $request
     * @param $offers
     * @return mixed
     */
    private function indexFilter($request, $offers)
    {
        $arraySearch = [];

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

    // PRIVATE
    /**
     * выбрать чат с данными контакта моего собеседника
     * @param $field
     * @param $offer_id
     * @return mixed
     */
    private function getChat($field, $offer_id)
    {
        $company = null;
        $my_id = Auth::user()->id;
        $offer = $this->model->where($field, $offer_id)
            ->with(["contact_one_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_one_user.position"])
            ->with(["contact_two_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_two_user.position"])
            ->firstOrFail();

        return $offer;
    }
}
