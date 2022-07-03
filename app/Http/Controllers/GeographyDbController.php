<?php

namespace App\Http\Controllers;

use App\Http\Requests\Locations\GetCitiesRequest;
use App\Http\Requests\Locations\GetRegionsRequest;
use App\Model\GeographyDb;
use Illuminate\Http\Request;

class GeographyDbController extends BaseController
{

    public function getRegion(GetRegionsRequest $request)
    {
        $coll = GeographyDb::find(1)->first();
        if(!is_null($coll)){
            if(isset($coll->regions['EN'][$request['country_code']])){
                return $this->getResponse($coll->regions['EN'][$request['country_code']]);
            }
        }
        return $this->getErrorResponse('Регион не найден');
    }

    public function getCity(GetCitiesRequest $request)
    {
        $coll = GeographyDb::find(1)->first();
        if(!is_null($coll)){
            if(isset($coll->cities['EN'][$request['region_code']])){
                return $this->getResponse($coll->cities['EN'][$request['region_code']]);
            }
        }
        return $this->getErrorResponse('Города не найдены');
    }

}
