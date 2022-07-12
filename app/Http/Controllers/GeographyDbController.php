<?php

namespace App\Http\Controllers;

use App\Http\Requests\Locations\GetCitiesRequest;
use App\Http\Requests\Locations\GetRegionsRequest;
use App\Model\GeographyDb;
use App\Model\GeographyTranslate;
use App\Services\LocalizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GeographyDbController extends BaseController
{
    protected $service;

    public function __construct() {
        parent::__construct();
        $this->service = new LocalizationService();
    }

    public function getRegion(GetRegionsRequest $request)
    {
        $locationRegions = GeographyDb::select('regions')->firstWhere('id', 1);

        $allRegions = $this->service->getRegions($request['lang_local'], $locationRegions);
        $allRegions = array_filter($allRegions, function ($item) use ($request) {
            return $item['prefix'] == $request['country_code'];
        });

        return $this->getResponse($allRegions);
    }

    public function getCity(GetCitiesRequest $request)
    {
        $locationCities = GeographyTranslate::select('cities')->firstWhere('id', 1);
        $allCities = $this->service->getCities($request['lang_local'], $locationCities);

        // города текущей страны
        $allCities = array_filter($allCities, function ($item) use ($request) {
            return $item['prefix'] == $request['country_code'];
        });

        // добавить в города код региона
        if(count($allCities)){
            $citiesArr_o = GeographyDb::select('cities')->firstWhere('id', 1)->cities["EN"];

            foreach ($allCities as $index => $arrayCity_t){
                foreach ($citiesArr_o as $code_region => $arrayCity_o){
                    $prefix_o = mb_strtolower(str_replace(' ', '_', $arrayCity_o[0]['name']));
                    if($prefix_o == $arrayCity_t['original_index']){
                        $allCities[$index]['code_region'] = $code_region;
                        break;
                    }
                }
            }
        }

        return $this->getResponse( $allCities );



//        return $this->getResponse( $request['country_code'] );
//        return $this->getResponse( $request['region_code'] );


//        $coll = GeographyDb::find(1)->first();
//        if(!is_null($coll)){
//            if(isset($coll->cities['EN'][$request['region_code']])){
//                return $this->getResponse($coll->cities['EN'][$request['region_code']]);
//            }
//        }
//        return $this->getErrorResponse('Города не найдены');
    }

}
