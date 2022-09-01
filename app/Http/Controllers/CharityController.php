<?php

namespace App\Http\Controllers;

use App\Http\Traits\MetaTrait;
use Illuminate\Http\Request;

class CharityController extends BaseController {
    use MetaTrait;

    public function showCharity() {
        $response = config("site.charity");
        $this->setMetaCharityPage();

        return view('charity.show-charity', compact("response"));
    }

}
