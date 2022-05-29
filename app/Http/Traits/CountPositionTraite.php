<?php
namespace App\Http\Traits;

use App\Model\Position;
use App\Model\UserContact;
use App\Model\Vacancy;

trait CountPositionTraite {

    /**
     * удалить старое название, если оно не будет никем использоватся
     * @param $request
     * @param $position_id
     */
    public static function deleteUnwantedVacancyTitle($request, $position_id) {
        $old_position = Position::where('id', $position_id)->first();
        // название изменено
        if($old_position && $old_position->title !== mb_strtolower($request->position, 'UTF-8')){
            $count_position = Vacancy::where('position_id', $position_id)->count();
            $count_position += UserContact::where('position_id', $position_id)->count();
            // название использовалось только в этом контакте
            if($count_position === 1){
                $old_position->delete();
            }
        }
    }

}
