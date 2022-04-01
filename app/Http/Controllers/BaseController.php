<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{
    public function getResponse($message = 'success', $status = 200) {
        return Response::json(compact('status', 'message'), 200);
    }

//    public function getErrorResponse($message, $httpStatus = 400) {
//        return Response::json([ "status" => 'error', "errors"  => $message], $httpStatus);
//    }
}
