<?php
namespace App\Repositories;

use App\Http\Traits\Geography\GeographyWorkSeparateEntryTraite;
use App\Http\Traits\LoadFileMethodsTraite;
use App\Model\Image;
use App\Model\UserCompany;
use App\Model\UserCompany as Model;
use Illuminate\Support\Facades\Auth;


class CompanyRepository extends CoreRepository {
    use LoadFileMethodsTraite, GeographyWorkSeparateEntryTraite;

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

        // с фронта пришел image
        if(!is_null($request->image)){
            // сохранить file
            $image = json_decode($request->image);
            $path = $this->savePhysically(
                $image,
                $this->path_logotype.date('m-Y'),
                $image->name
            );
            // сохранить данные картинки в базу
            $arr['logo_id'] = $this->saveImageDataToDatabase($path, null, 0);
        }

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
        if(!is_null($request->image)){

            // 1 существует logotype у company
            if(!is_null($company->logo_id)){
                $coll = Image::find($company->logo_id);
                // удалить физически
                $this->deletePhysically($coll->url);
            }
            // 2 сохранить file
            $image = json_decode($request->image);
            $path = $this->savePhysically(
                $image,
                $this->path_logotype.date('m-Y'),
                $image->name
            );
            // 3 сохранить данные картинки в базу
            $arr['logo_id'] = $this->saveImageDataToDatabase($path, $company->logo_id, 0);
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
            'country_id' => $this->createSpecifiedLocationRecord($request, 'country', 0),
            'region_id' => $this->createSpecifiedLocationRecord($request, 'region', 1),
            'city_id' => $this->createSpecifiedLocationRecord($request, 'city', 2),
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

}
