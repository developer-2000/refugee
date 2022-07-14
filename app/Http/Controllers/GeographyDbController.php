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

    public function getRegions(GetRegionsRequest $request)
    {
        $allRegions = $this->service->getRegions($request['lang_local']);
        $allRegions = array_filter($allRegions, function ($item) use ($request) {
            return $item['prefix'] == $request['country_code'];
        });

        return $this->getResponse($allRegions);
    }

    public function getCities(GetCitiesRequest $request)
    {
        $allCities = $this->service->getCities($request['lang_local']);

        // города текущей страны и региона
        $allCities = array_filter($allCities, function ($item) use ($request) {
            return $item['prefix'] == $request['country_code'] && $item['code_region'] == $request['region_code'];
        });

        return $this->getResponse( count($allCities) ? $allCities : null );
    }

}
