<?php
namespace App\Http\Traits;

trait FunctionsTraite {

    public function LastElementArray($array)
    {
        if (!is_array($array) || empty($array)) {
            return [''];
        }
        return array_slice($array, -1);
    }

    public function PenultimateElementArray($array)
    {
        if (!is_array($array) || empty($array)) {
            return [''];
        }
        return array_slice($array, -2);
    }

}
