<?php
namespace App\Repositories;

use App\Model\Image;
use App\Model\Position;
use App\Model\UserCompany;
use App\Model\UserCompany as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyRepository extends CoreRepository {

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
    }

    public function storeCompany($request){
        // защита от повтора
        if(UserCompany::where('user_id', Auth::user()->id)->first()){
            return true;
        }

        $arr = $this->makeArrayCompany($request);
        // 1
        $arr['user_id'] = Auth::user()->id;

        // сохранить логотип
        if(!is_null($path = $this->saveImage($request))){
            // запись в базу
            $arrPath = explode("/", $path);
            $image = Image::create([
                "title"=>$arrPath[count($arrPath)-1],
                "url"=>$path,
                "type"=>0,
            ]);
            // 2
            $arr['logo_id'] = $image->id;
        }

        $count = UserCompany::where('alias', 'like', $request->alias . '%')->count();
        // 3
        $arr['alias'] = $count > 0 ? $request->alias.'-'.$count : $request->alias;

        return $this->model->create($arr);
    }

    private function makeArrayCompany($request){
        return [
            'title'=>$request->title,
            'country'=>json_decode($request->country[0]),
            'region'=>$request->region != null ? json_decode($request->region[0]) : null,
            'city'=>$request->city != null ? json_decode($request->city[0]) : null,
            'rest_address'=>$request->rest_address,
            'categories'=>$request->categories,
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

    private function saveImage($request){
        $path = null;
        if(!is_null($request->load_logotype)){
            $path = '/img/company/logotypes/'.date('m-Y');

            $file = $request->load_logotype->getClientOriginalName();
            $filename = mb_strtolower(pathinfo($file, PATHINFO_FILENAME));
            $extension = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $name = $filename.'-'.(string)(microtime(true)*10000).'.'.$extension;

            $path = Storage::disk('app_public')->putFileAs( $path, $request->load_logotype, $name);
        }

        return $path;
    }
}
