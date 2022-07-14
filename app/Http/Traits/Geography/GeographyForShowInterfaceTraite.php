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
        $address = [];

        // первый страна
        if(isset($collection->country)){
            $localisationService = new LocalizationService();
            $address["country"] = $localisationService->getCountryForShow($collection->country['local']['prefix']);
            // если есть город, регион не важен
            if(isset($collection->city)){
                $address["city"] = $localisationService->getCityForShow($collection->city['local']);
            }
            elseif(isset($collection->region)){
                $address["region"] = $localisationService->getRegionForShow($collection->region['local']);
            }
        }

        return $collection->setAttribute('address', $address);
    }

    /**
     * аналогия addPropertiesToCollection - но для ранее затронутой коллекции. Они изменены на Array
     * @param $collection
     * @return mixed
     */
    public function addPropertiesToCollection_ForAffectedCollection($collection){
        $address = [];

        // первый страна
        if(isset($collection['country'])){
            $localisationService = new LocalizationService();
            $address["country"] = $localisationService->getCountryForShow($collection['country']['local']['prefix']);
            // если есть город, регион не важен
            if(isset($collection['city'])){
                $address["city"] = $localisationService->getCityForShow($collection['city']['local']);
            }
            elseif(isset($collection['region'])){
                $address["region"] = $localisationService->getRegionForShow($collection['region']['local']);
            }
        }

        return $collection->put('address', $address);
    }

}
