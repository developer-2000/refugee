<?php

namespace App\Http\Controllers;

use App\Services\MetaService;


class PoliceController extends Controller {

    protected $metaService = '';

    public function __construct() {
        $this->metaService = new MetaService();
    }

    public function showCookiePage(){
        $this->metaService->setMetaCookiePolicyPage();

        return view("police.cookie_police_".app()->getLocale());
    }

    public function showTermsUsePage(){
        $this->metaService->setMetaTermsUsePage();
        $app_url = env("APP_URL", "");

        return view("police.terms_use_".app()->getLocale(), compact("app_url"));
    }

}
