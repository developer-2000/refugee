<?php

namespace App\Http\Controllers;

use App\Model\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller {



    public function create()
    {
        $settings = config('site.settings_vacancy');
        return view('create_vacancy', compact('settings'));
    }

    //    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Model\Vacancy  $vacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Vacancy $vacancy)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Model\Vacancy  $vacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Vacancy $vacancy)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Model\Vacancy  $vacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, Vacancy $vacancy)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Model\Vacancy  $vacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Vacancy $vacancy)
//    {
//        //
//    }
}
