<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * смена языка на сайте
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($name) {
        // пришел доступный язык ?
        if (in_array( $name, array_keys(config('site.locale.languages')) )) {
            session(['locale' => $name]);
        }

        return redirect()->back();
    }
}
