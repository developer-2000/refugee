<?php
namespace App\Http\Traits\Geography;

use App\Model\GeographyLocal;

trait GeographyWorkSeparateEntryTraite {

    /**
     * создает указанную запись - страна, регион, город
     * и возвращает id записи
     * @param $request
     * @param $property
     * @param  int  $type
     * @param  string  $prefix
     * @return |null
     */
    private function createSpecifiedLocationRecord($request, $property, $type=0){
        $col_id = null;

        if(!is_null($request->$property)){
            $coll = GeographyLocal::firstOrCreate(
                [
                    "local->original_index" => $request->$property['original_index'],
                    "local->prefix" => $request->$property['prefix'],
                    'type' => $type
                ],
                [
                    'local' => $request->$property,
                    'alias' => $request->$property['original_index'],
                    'type' => $type
                ]
            );
            $col_id = $coll->id;
        }

        return $col_id;
    }

}
