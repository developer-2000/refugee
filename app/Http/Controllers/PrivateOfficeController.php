<?php
namespace App\Http\Controllers;

use App\Model\UserCompany;
use Illuminate\Support\Facades\Auth;

class PrivateOfficeController extends BaseController
{
    public function index() {
        $company = UserCompany::where('user_id', Auth::user()->id)
            ->with('image')->first();

//        dd(app()->getLocale());

        return view('private_office', compact('company'));
    }
}
