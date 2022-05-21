<?php
namespace App\Http\Controllers;

use App\Model\UserCompany;
use Illuminate\Support\Facades\Auth;

class PrivateOfficeController extends BaseController
{
    public function index() {
        $company = UserCompany::where('user_id', Auth::user()->id)
            ->with('image')->firstOrFail();

        return view('private_office', compact('company'));
    }
}
