<?php

namespace App\Http\Controllers;

use App\Model\Vacancy;
use Illuminate\Http\Request;

class SiteMapController extends Controller {

    /**
     * разветвление на файлы sitemap
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->view('sitemap.index')
            ->header('Content-Type', 'text/xml');
    }

    public function pages() {
//        $vacancies = Vacancy::latest()->get(); , compact("vacancies")

        return response()->view('sitemap.pages')
            ->header('Content-Type', 'text/xml');
    }

}
