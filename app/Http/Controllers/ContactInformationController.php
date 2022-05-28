<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactInformationController extends BaseController
{

    public function index()
    {

        return view('contact_information');
    }
}
