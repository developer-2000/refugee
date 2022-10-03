<?php
namespace App\Services;


class InstrumentService {


    /**
     * вернет строку с первым символом в верхнем регистре
     * @param $str
     * @return string
     */
    public function firstSymbolStringUppercase($str) {
        return  mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
    }


}
