<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\BreadcrumbsTraite;
use App\Repositories\VacancyRepository;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class BaseController extends Controller {
    use BreadcrumbsTraite;

    public function __construct() {
        $this->setElementsBread();

        View::composer('*', function ($view) {
            // масив с обратными url страниц
            $back_url = $this->getElementsBread();
            $view->with(compact('back_url'));
        });
    }

    public function getResponse($message = '', $status = 'success',  $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

    public function getErrorResponse($message = '', $status = 'error', $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

}
