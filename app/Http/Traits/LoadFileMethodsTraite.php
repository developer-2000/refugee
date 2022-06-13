<?php
namespace App\Http\Traits;

use App\Model\Image;
use Illuminate\Support\Facades\Storage;

trait LoadFileMethodsTraite {

    // удалить физически файл.папку
    public function deletePhysically($url) {
        if (Storage::disk('app_public')->has($url)){
            Storage::disk('app_public')->delete($url);
            return true;
        }
        return false;
    }

    // сохранить file
    public function savePhysically($file, $path){
//        $original_name = $file->getClientOriginalName();
        $filename = mb_strtolower(pathinfo($file->name, PATHINFO_FILENAME));
        $extension = mb_strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
        $name = $filename.'-'.(string)(microtime(true)*10000).'.'.$extension;
        // save
        $path = Storage::disk('app_public')->putFileAs( $path, $file->file, $name);

        return $path;
    }

    // сохранить данные картинки в базу
    public function saveImageDataToDatabase($path, $image_id, $type){
        $id = null;
        // запись в базу
        $arrPath = explode("/", $path);
        $arrParams = [
            "title"=>$arrPath[count($arrPath)-1],
            "url"=>$path,
            "type"=>$type,
        ];

        if(!is_null($image_id)){
            Image::where('id', $image_id)
                ->update($arrParams);
            $id = $image_id;
        }
        else{
            $image = Image::create($arrParams);
            $id = $image->id;
        }

        return $id;
    }
}
