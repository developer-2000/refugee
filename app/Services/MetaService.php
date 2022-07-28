<?php
namespace App\Services;

use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\App;

class MetaService
{

    /**
     * Формирует масив Hreflang для Мета тегов
     * @return array
     */
    public function getArrHreflang() {
        // языки переводов сайта
        $prefix_translate = config("app.alternative_lang");
        //[ "scheme" => "http", "host" => "refugee", "path" => "/ru" ]
        $boneUrl = parse_url(url()->current());
        $path = "";
        $arrTranslate = [];

        if(isset($boneUrl["path"])){
            $path = $boneUrl["path"];
            $start_line = substr($path, 1, 2);
            // удалить префикс языка из $path
            if (in_array($start_line, $prefix_translate)) {
                $path = substr($path, 3);
                $path = $path !== "" ? $path : "";
            }
        }

        foreach ($prefix_translate as $key => $prefix){
            $arrTranslate[] = [
                "href" => $boneUrl["scheme"]."://".$boneUrl["host"]."/".$prefix.$path,
                "hreflang" => $prefix,
            ];
        }
        $elementDifference = array_diff(config("app.all_lang"), config("app.alternative_lang"));
        $arrTranslate[] = [
            "href" => $boneUrl["scheme"]."://".$boneUrl["host"].$path,
            "hreflang" => isset($elementDifference[0]) ? $elementDifference[0] : "en",
        ];
        $arrTranslate[] = [
            "href" => url()->current(),
            "hreflang" => "x-default",
        ];

        return $arrTranslate;
    }

}
