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
     * вернет разницу в днях между старой датой и сейчас
     * @param $old_date
     * @param  int  $add_time
     * @param  int  $type_add_time
     * @return int
     * @throws \Exception
     */
    public function returnDifferenceDateDays($old_date, $add_time = 0, $type_add_time = 0) {
        $timeOptions = [ "second", "minute", "hour", "day", "month", "year"];
        $old_date = Carbon::parse($old_date);
        $now = Carbon::now()->format('Y-m-d');
        $now = new \DateTime($now);

        // добавить к дате дни
        if($timeOptions[$type_add_time] == "day"){
            $old_date = Carbon::parse($old_date)->addDays($add_time)->format('Y-m-d');
        }

        $old_date = new \DateTime($old_date);

        // разница в днях
        return (integer)$now->diff($old_date)->format('%R%a');
    }

}
