<?php
namespace App\Http\Traits\Geography;

use App\Services\LocalizationService;

trait GeographyForShowInterfaceTraite {

    /**
     * добавить данные страна, регион, город в коллекцию
     * @param $collection
     * @return mixed
     */
    public function addPropertiesToCollection($collection){
        $localisationService = new LocalizationService();
        $address = [];

        // первый страна
        if(isset($collection->country) && !is_null($collection->country)){
            $address["country"] = $localisationService->getCountryForShow($collection->country['local']['prefix']);

            // если есть город, регион не важен
            if(isset($collection->city) && !is_null($collection->city)){
                $address["city"] = $localisationService->getCityForShow($collection->city['local']);
            }
            elseif(isset($collection->region) && !is_null($collection->region)){
                $address["region"] = $localisationService->getRegionForShow($collection->region['local']);
            }
        }

        return $collection->setAttribute('address', $address);
    }







}
