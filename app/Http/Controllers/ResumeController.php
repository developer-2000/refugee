<?php

namespace App\Http\Controllers;

use App\Model\MakeGeographyDb;
use App\Repositories\ResumeRepository;
use Illuminate\Http\Request;

class ResumeController extends BaseController {

    protected $repository;

    public function __construct() {
        parent::__construct();

        $this->repository = new ResumeRepository();
    }



    public function create()
    {
        $settings = $this->getSettingsResumeAndCountries();
        return view('resume.create_resume', compact('settings'));
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
//     * @param  \App\Model\Resume  $resume
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Resume $resume)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Model\Resume  $resume
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Resume $resume)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Model\Resume  $resume
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, Resume $resume)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Model\Resume  $resume
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Resume $resume)
//    {
//        //
//    }

    /**
     * настройки параметров и страны сайта
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getSettingsResumeAndCountries(){
        $settings = config('site.settings_vacancy');
        if($objCountries = MakeGeographyDb::where('id', 1)->select('country')->first()){
            $settings['obj_countries'] = $objCountries['country']['EN'];
        }
        $settings['categories'] = config('site.categories.categories');
        return $settings;
    }

    public function myResume()
    {
        return view('resume.create_resume');
    }
}
