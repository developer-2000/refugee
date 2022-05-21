<?php

namespace App\Http\Controllers;

use App\Model\UserCompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function show($alias){
        $company = UserCompany::where('alias', $alias)
            ->with('image')->firstOrFail();

        return view('company', compact('company'));
    }
}
