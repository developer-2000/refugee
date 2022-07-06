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

    public function getResponse($message = '', $status = 'success',  $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

    public function getErrorResponse($message = '', $status = 'error', $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

}
