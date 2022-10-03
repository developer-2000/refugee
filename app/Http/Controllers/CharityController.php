<?php

namespace App\Http\Controllers;

use App\Services\MetaService;
use Illuminate\Http\Request;

class CharityController extends BaseController {

    protected $metaService = '';

    public function __construct() {
        $this->metaService = new MetaService();
    }

    public function showCharity() {
        $response = config("site.charity");
        $this->metaService->setMetaCharityPage();

        return view('charity.show-charity', compact("response"));
    }

}
