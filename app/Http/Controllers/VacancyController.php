<?php
namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\StoreVacancyRequest;
use App\Model\MakeGeographyDb;
use App\Repositories\VacancyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VacancyController extends BaseController {

    protected $repository;

    public function __construct() {
        $this->repository = new VacancyRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $settings = config('site.settings_vacancy');
        if($objCountries = MakeGeographyDb::find(1)->first()->pluck('country')){
            $settings['obj_countries'] = $objCountries[0]['EN'];
        }
        return view('create_vacancy', compact('settings'));
    }

    public function store(StoreVacancyRequest $request)
    {
        $store = $this->repository->storeVacancy($request);
        return $this->getResponse($store);
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
