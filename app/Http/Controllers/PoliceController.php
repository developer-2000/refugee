<?php

namespace App\Http\Controllers;

use App\Http\Traits\MetaTrait;
use Illuminate\Http\Request;

class PoliceController extends Controller {
    use MetaTrait;

    public function showCookiePage(){
        $this->setMetaCookiePolicyPage();

        return view("police.cookie_police_".app()->getLocale());
    }

    public function showTermsUsePage(){
        $this->setMetaTermsUsePage();

        return view("police.terms_use_".app()->getLocale());
    }

}