<?php
namespace App\Http\Traits;

use Illuminate\Support\Carbon;

trait DateTrait
{
    // строковое время "25 Jun 2022 16:15"
    public function getNowDate()
    {
        return Carbon::now()->format('d M Y H:i');
    }

}
