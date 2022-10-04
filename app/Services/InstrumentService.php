<?php
namespace App\Services;


use Illuminate\Support\Carbon;

class InstrumentService {


    /**
     * вернет строку с первым символом в верхнем регистре
     * @param $str
     * @return string
     */
    public function firstSymbolStringUppercase($str) {
        return  mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
    }

    /**
     * вернет разницу в миллисекундах между старой датой и сейчас
     * @param $old_date
     * @param  int  $add_time
     * @param  int  $type_add_time
     * @return float
     */
    public function returnDifferenceDateMilliseconds($old_date, $add_time = 0, $type_add_time = 0) {
        $timeOptions = [ "second", "minute", "hour", "day", "month", "year"];
        $date = Carbon::parse($old_date);

        // добавить к дате дни
        if($timeOptions[$type_add_time] == "day"){
            $date = $date->addDays($add_time);
        }

        // разница в миллисекундах
        $limit = $date->valueOf() - Carbon::now()->valueOf();

        return $limit;
    }

}
