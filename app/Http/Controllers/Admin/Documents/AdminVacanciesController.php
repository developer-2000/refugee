<?php
namespace App\Http\Controllers\Admin\Documents;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Model\Vacancy;


class AdminVacanciesController extends AdminBaseController {

//    public function __construct() {
//        parent::__construct();
//    }

    public function index(){

        $vacancies = Vacancy::with("position")->paginate(2);
        $response = [
            "vacancies"=>$vacancies,
        ];

        return view('admin_panel.admin_panel', compact('response'));
    }

}
