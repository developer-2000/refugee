<?php
namespace App\Http\Traits\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

trait AdminTranslateLocationTrait
{

    // преобразует название страны, города в рабочий alias
    private function nameToAliasConversion($name){
        $prefix = mb_strtolower($name);
        $prefix = str_replace(" ", "-", $prefix);
        $prefix = str_replace("'", "", $prefix);
        $prefix = str_replace("’", "", $prefix);
        $prefix = str_replace(",", "", $prefix);
        $prefix = str_replace(".", "", $prefix);

        return $prefix;
    }

    /**
     * удалить найденный по value елемент масива
     * @param $value
     * @param $arrElements
     * @return array
     */
    private function removeSpecifiedElementFromArray($value, $arrElements){
        $key = array_search($value, $arrElements);
        if($key !== false){
            unset($arrElements[$key]);
            $arrElements = array_values($arrElements);
        }
        return $arrElements;
    }

    /**
     * сортировка многомерного масива на возростание по value ключа
     * @param $array
     * @param $key
     * @return mixed
     */
    private function sortingMultidimensionalArrayByKey($array, $key){
        usort($array, function($a,$b) use ($key){
            return ($a[$key] > $b[$key]);
        });
        return $array;
    }

    /**
     * оставляет только то чему равен префикс
     * @param $array
     * @param $index
     * @param $value
     * @return array
     */
    private function filter($array, $index, $value){
        $array = array_filter($array, function ($item) use ($index, $value) {
//            if($value == 'ua' && $item[$index] == 'ua'){
//                dd([$item, $index, $value]);
//            }

            return $item[$index] === $value;
        });
        return $array;
    }

    /**
     * custom paginate for array
     * @param $translateRegions
     * @param $prefix_lang
     * @return int
     */
    private function paginate($items, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->count_pagination), $items->count(), $this->count_pagination, $page, $options);
    }

    /**
     * формирует строку в виде обьекта и пересоздает файл
     * @param $arrElements
     * @param $country
     * @param $full_url
     */
    private function makeFileTranslate($arrElements, $country, $full_url){
        $line = "<?php \n\n  return [\n ";
        foreach ($arrElements as $prefix => $value){
            $prefix = addslashes($prefix);
            $value = addslashes($value);
            $line .= "'$prefix'=>'$value',\n ";
        }
        $line .= "];";

        $this->createDir(public_path().$full_url);
        file_put_contents(public_path().$full_url.$country.".php", $line);
    }

    /**
     * создать папку если не существует
     * @param $path
     */
    private function createDir($path){
    if (!is_dir($path)) {
        mkdir($path);
    }
}

    /**
     * елементы масива в нижнем регистре, пробелы подчеркнуты
     * @param $regionArr
     * @return string|string[]
     */
    private function arrayElementsLowercaseUnderscore($regionArr){
        foreach ($regionArr as $index => $value) {
            $regionArr[$index] = $this->nameToAliasConversion($value);
        }
        return $regionArr;
    }

    /**
     * найти в оригинале index перевода
     * @param $arrElements_o
     * @param $search_property
     * @return array
     */
    private function searchOriginal($arrElements_o, $search_property){
        $newArr = [];

        // переберает регионы или города
        foreach ($arrElements_o as $index => $value){

            // в случае regions
            if(is_array($value)){
                $property = $this->nameToAliasConversion($value["name"]);
                // нашел свойство региона
                if($property == $search_property){
                    $newArr['original_index'] = $property;
                    $newArr['code_region'] = $value["code"];
                    break 1;
                }
            }
            // в случае cities
            else{
                // нашел свойство
                if($value == $search_property){
                    $newArr['original_index'] = $value;
                    break 1;
                }
            }

        }
        // если совпадений свойства небыло
        if(!isset($newArr['original_index'])){
            $newArr['error_index'] = [];
        }

        return $newArr;
    }

}
