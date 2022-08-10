<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliceController extends Controller
{
    public function showCookiePage(){

        return view('police.cookie_police');
    }

    public function showTermsPage(){

    }

}
