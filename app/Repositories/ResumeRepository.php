<?php
namespace App\Repositories;

use App\Http\Traits\CountPositionTraite;
use App\Model\Position;
use App\Model\UserResume as Model;
use Illuminate\Support\Facades\Auth;

class ResumeRepository extends CoreRepository {
    use CountPositionTraite;

    protected $settings;

    public function __construct() {
        $this->model = clone app(Model::class);
    }


}
