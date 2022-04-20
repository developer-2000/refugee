<?php

namespace App\Http\Controllers;


use App\Http\Requests\SearchVacancy\JobSearchRequest;
use App\Model\MakeGeographyDb;
use App\Model\SearchVacancy;
use App\Model\User;
use App\Model\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchVacancyController extends Controller
{

    public function index()
    {
        $settings = config('site.settings_vacancy');

        if($objCountries = MakeGeographyDb::where('id', 1)->select('country')->first()){
            $settings['obj_countries'] = $objCountries['country']['EN'];
        }

        $vacancies = Vacancy::with('position','employer.logo')
            ->paginate(10)->toArray();

//        dd($vacancies['data'][1]);
        return view('index', compact('settings', 'vacancies'));
    }

//    public function jobSearch($country = null,$region = null,$city = null, JobSearchRequest $request) {
//        $settings = config('site.settings_vacancy');
//        if($objCountries = MakeGeographyDb::find(1)->first()->pluck('country')){
//            $settings['obj_countries'] = $objCountries[0]['EN'];
//        }
//
////dd($request->all());
//
////        $data = Vacancy::where('vacancy_suitable->inputs->suitable_to', 60)
////            ->get();
//
//        return view('index', compact('settings'));
//    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }
//
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
//     * @param  \App\Model\SearchVacancy  $searchVacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function show(SearchVacancy $searchVacancy)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Model\SearchVacancy  $searchVacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(SearchVacancy $searchVacancy)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Model\SearchVacancy  $searchVacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, SearchVacancy $searchVacancy)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Model\SearchVacancy  $searchVacancy
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(SearchVacancy $searchVacancy)
//    {
//        //
//    }
}
