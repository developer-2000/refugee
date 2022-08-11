<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliceController extends Controller
{
    public function showCookiePage(){

        return view("police.cookie_police_".app()->getLocale());
    }

    public function showTermsUsePage(){

        return view("police.terms_use_".app()->getLocale());
    }

}
