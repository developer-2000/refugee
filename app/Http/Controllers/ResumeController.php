<?php

namespace App\Http\Controllers;

use App\Http\Requests\Resume\StoreResumeRequest;
use App\Model\MakeGeographyDb;
use App\Model\UserResume;
use App\Model\Vacancy;
use App\Repositories\ResumeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(StoreResumeRequest $request)
    {
        $resume = $this->repository->storeResume($request);
        return $this->getResponse($resume);
    }


    /**
     * Все мои резюме в офисе
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myResumes()
    {
        $settings = $this->getSettingsResumeAndCountries();
        $resumes = UserResume::where('user_id', Auth::user()->id)
            ->with('position', 'contact.avatar')
            ->withCount('respond')
            ->get();

        return view('resume.my_resumes', compact('resumes','settings'));
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

}
