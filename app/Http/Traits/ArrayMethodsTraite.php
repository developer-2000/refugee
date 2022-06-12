<?php
namespace App\Http\Traits;

trait ArrayMethodsTraite {

    // отдать последний елемент
    public function LastElementArray($array)
    {
        if (!is_array($array) || empty($array)) {
            return [''];
        }
        return array_slice($array, -1);
    }

    // отдать 2 последних елемента
    public function PenultimateElementArray($array)
    {
        if (!is_array($array) || empty($array)) {
            return [''];
        }
        return array_slice($array, -2);
    }

}
