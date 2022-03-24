<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryShowRequest;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function show(CountryShowRequest $request)
    {
        return view('welcome');
    }
}
