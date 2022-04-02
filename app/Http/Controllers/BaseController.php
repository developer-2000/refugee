<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{
    public function getResponse($message = '', $status = 'success',  $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }

    public function getErrorResponse($message = '', $status = 'error', $code = 200) {
        return Response::json(compact('message', 'status'), $code);
    }
}
