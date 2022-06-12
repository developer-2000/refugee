<?php
namespace App\Repositories;

use App\Http\Traits\CountPositionTraite;
use App\Http\Traits\LoadFileMethodsTraite;
use App\Model\Image;
use App\Model\Position;
use App\Model\UserCompany;
use App\Model\UserCompany as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyRepository extends CoreRepository {
    use LoadFileMethodsTraite;

    protected $settings;
    protected $path_logotype;

    public function __construct() {
        $this->model = clone app(Model::class);
        $this->path_logotype = '/img/company/logotypes/';
    }

    public function storeCompany($request){
        // защита от повтора
        if(UserCompany::where('user_id', Auth::user()->id)->first()){
            return true;
        }

        $arr = $this->makeArrayCompany($request);
        // 1
        $arr['user_id'] = Auth::user()->id;

        // сохранить file
        $path = $this->savePhysically( $request->load_logotype, $this->path_logotype.date('m-Y') );
        // сохранить данные картинки в базу
        $arr['logo_id'] = $this->saveImageDataToDatabase($path, null, 0);

        // 4 существует чужой alias
        if(!is_null($this->checkTransliteration($request->alias))){
            $arr['alias'] = $request->alias.'-'.$this->renderIndexTransliteration($request->alias);
        }
        else{
            $arr['alias'] = $request->alias;
        }

        return $this->model->create($arr);
    }

    public function updateCompany($request, $company){
        $arr = $this->makeArrayCompany($request);

        // добавление / замена
        // с фронта пришел файл image
        if(!is_null($request->load_logotype)){

            // 1 существует logotype у company
            if(!is_null($company->logo_id)){
                $coll = Image::find($company->logo_id);
                // удалить физически
                $this->deletePhysically($coll->url);
            }
            // 2 сохранить file логотип
            $path = $this->savePhysically( $request->load_logotype, $this->path_logotype.date('m-Y') );
            // 3 сохранить данные картинки в базу
            $arr['logo_id'] = $this->saveImageDataToDatabase($path, $company->logo_id, 0);
        }

        // 4 замена alias
        // существует чужой alias
        if(!is_null($this->checkTransliteration($request->alias))){
            $arr['alias'] = $request->alias.'-'.$this->renderIndexTransliteration($request->alias);
        }
        else{
            $arr['alias'] = $request->alias;
        }

        return $this->model->where('id', $request->company_id)
            ->where('user_id', Auth::user()->id)
            ->update($arr);
    }

    /**
     * проверка на существования такого translit title company
     * @param $alias
     * @return mixed
     */
    public function checkTransliteration($alias){
        return $this->model->where('alias', $alias)
            ->where('user_id', '!=', Auth::user()->id)
            ->first();
    }

    /**
     * Генерирует уникальный index translit title company
     * @param $alias
     * @return int
     */
    private function renderIndexTransliteration($alias){
        $index = 1;

        while(true){
            if(is_null($this->checkTransliteration("$alias-$index"))){
                break;
            }
            else{
                $index++;
            }
        }

        return $index;
    }

    private function makeArrayCompany($request){
        return [
            'title'=>$request->title,
            'country'=>$this->convertingToJson($request->country[0]),
            'region'=> ($request->region != null) ? $this->convertingToJson($request->region[0]) : null,
            'city'=> ($request->city != null) ? $this->convertingToJson($request->city[0]) : null,
            'rest_address'=>$request->rest_address,
            'categories'=>array_map('intval', $request->categories),
            'youtube_links'=>$request->youtube_links,
            'tax_number'=>$request->tax_number,
            'founding_date'=>$request->founding_date,
            'facebook_social'=>$request->facebook_social,
            'instagram_social'=>$request->instagram_social,
            'telegram_social'=>$request->telegram_social,
            'twitter_social'=>$request->twitter_social,
            'site_company'=>$request->site_company,
            'count_working_company'=>$request->count_working,
            'about_company'=>$request->about_company,
        ];
    }

    private function convertingToJson($value){
        $result = json_decode($value, true);
        // ошибки нет
        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }

        return $value;
    }

//    private function saveImage($request){
//        $path = null;
//        if(!is_null($request->load_logotype)){
//            $path = '/img/company/logotypes/'.date('m-Y');
//
//            $file = $request->load_logotype->getClientOriginalName();
//            $filename = mb_strtolower(pathinfo($file, PATHINFO_FILENAME));
//            $extension = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION));
//            $name = $filename.'-'.(string)(microtime(true)*10000).'.'.$extension;
//
//            $path = Storage::disk('app_public')->putFileAs( $path, $request->load_logotype, $name);
//        }
//
//        return $path;
//    }
}
