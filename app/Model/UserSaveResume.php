<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSaveResume extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function resume() {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }
}
