<?php
namespace App\Http\Traits\Geography;

trait GeographyFilesTraite {

    /**
     * создает файлы стран в оригинале перевода
     * @param $array
     */
    public function createFilesCountry($array){
        $url_country = config('site.locale.url_country');

        foreach ($array as $key => $arr){
            $line = "<?php \n\n  return [\n ";
            $prefix = $this->clearNameToAliasConversion($arr["name"]);

            $value = addslashes($arr["name"]);
            $line .= "'$prefix'=>'$value',\n ";
            $line .= "];";

            $code = mb_strtolower($arr["code"]);
            file_put_contents(public_path().$url_country['original'].$code.".php", $line);
        }
    }

    /**
     * создает файлы регеонов в оригинале перевода
     * @param $array
     * @param  string  $prefix
     */
    public function createFilesRegion($array){
        $url_region = config('site.locale.url_region');

        foreach ($array as $key_name => $arr){
            $line = "<?php \n\n  return [\n ";
            foreach ($arr as $index => $arr2){
                $prefix = $this->clearNameToAliasConversion($arr2["name"]);
                $value = addslashes($arr2["name"]);
                $line .= '"'.$prefix.'"=>"'.$value.'",'."\n";
            }
            $line .= "];";

            $code = mb_strtolower($key_name);
            file_put_contents(public_path().$url_region['original'].$code.".php", $line);
        }
    }

    /**
     * подготавливает данные для создания файлов городов
     * @param $array
     * @param  string  $prefix
     */
    public function makeFilesCity($array, $prefix=''){
        $url_city = config('site.locale.url_city');
        $arrCountries = [];

        // страны, регионы и города в них
        // ['UA'[ 686966[ "name" => "Zhytomyr", ...
        foreach ($array as $code_region => $arr_cities) {
            $prefix_country = $this->returnNameCountry($this->arrLangRegion['EN'], $code_region);

            // новый масив страны
            if(!isset($arrCountries[$prefix_country])){
                $arrCountries[$prefix_country] = [];
                $arrCountries[$prefix_country][$code_region] = [];
            }

            // внести этот регион с городами
            foreach($arr_cities as $index => $city){
                $arrCountries[$prefix_country][$code_region][] = ['name'=>$city["name"]];
            }
        }

        foreach ($arrCountries as $prefix_country => $arrRegions) {
            $this->createFileCity($arrRegions, $prefix_country, public_path().$url_city['original']);

        }
    }

    /**
     * создает файл городов своей страны
     * @param $arrRegions
     * @param $prefix_country
     * @param $url_dir
     */
    public function createFileCity($arrRegions, $prefix_country, $url_dir){
        $line = "<?php \n\n  return [\n ";
        foreach ($arrRegions as $code_region => $arrCities) {
            $line .= " '$code_region' => [\n ";
            // строка города
            foreach ($arrCities as $index => $city) {

                if(isset($city["name"])){
                    $prefix = $this->clearNameToAliasConversion($city["name"]);
                    $name = addslashes($city["name"]);
                }
                else{
                    $prefix = $index;
                    $name = addslashes($city);
                }

                $line .= '"'.$prefix.'"=>"'.$name.'",'."\n";
            }
            $line .= " ], \n";
        }
        $line .= "];";

        $this->createDir2($url_dir);
        $code_country = mb_strtolower($prefix_country);
        file_put_contents($url_dir.$code_country.".php", $line);
    }

    private function returnNameCountry($array, $code){
        $nameReg = null;
        foreach ($array as $name => $arr) {
            // var_dump( $arr );
            if (array_search($code, array_column($arr, 'code')) !== false) {
                $nameReg = $name;
                break;
            }
        }
        return $nameReg;
    }

    /**
     * преобразует название страны, города в рабочий alias
     * @param $name
     * @return bool|false|string|string[]|null
     */
    private function clearNameToAliasConversion($name){
        $prefix = mb_strtolower($name);
        $prefix = str_replace(" ", "-", $prefix);
        $prefix = str_replace("'", "", $prefix);
        $prefix = str_replace("’", "", $prefix);
        $prefix = str_replace(",", "", $prefix);
        $prefix = str_replace(".", "", $prefix);
        return $prefix;
    }

    /**
     * создать папку если не существует
     * @param $path
     */
    private function createDir2($path){
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

}
