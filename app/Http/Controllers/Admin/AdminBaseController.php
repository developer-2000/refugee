<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\BreadcrumbsTraite;
use App\Repositories\VacancyRepository;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AdminBaseController extends Controller {

    public function __construct() {
        $this->defaultView();
    }

    public function getResponse($message = '', $status = 'success',  $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

    public function getErrorResponse($message = '', $status = 'error', $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

    private function defaultView() {
        View::composer('*', function ($view) {
            $logo_text = ["uk"=>env("APP_NAME_UK"), "en"=>env("APP_NAME_EN")];

            $view->with(compact('logo_text'));
        });
    }
}
