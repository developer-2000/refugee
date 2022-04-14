<?php
namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\SearchVacancyRequest;
use App\Http\Requests\Vacancy\StoreVacancyRequest;
use App\Http\Requests\Vacancy\UpVacancyStatusRequest;
use App\Model\MakeGeographyDb;
use App\Model\Position;
use App\Model\User;
use App\Model\Vacancy;
use App\Repositories\VacancyRepository;
use Illuminate\Support\Facades\Auth;

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
        return view('vacancies/create_vacancy', compact('settings'));
    }

    /**
     * создать вакансию
     * @param  StoreVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreVacancyRequest $request)
    {
        $store = $this->repository->storeVacancy($request);
        return $this->getResponse($store);
    }

    /**
     * найти должность по первым символам
     * @param  SearchVacancyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchVacancy(SearchVacancyRequest $request)
    {
        $position = Position::where('active',1)
            ->where('title', 'like', $request->value.'%')
            ->get()
            ->pluck('title');
        return $this->getResponse(compact('position'));
    }

    /**
     * выбрать все свои вакансии
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myVacancies()
    {
        $settings = config('site.settings_vacancy');
        $user_data = User::where('id', Auth::user()->id)
            ->with('vacancies.position')
            ->first();
        return view('vacancies/my_vacancies', compact('user_data','settings'));
    }

    /**
     * обновить статус вакансии
     * @param  UpVacancyStatusRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upVacancyStatus(UpVacancyStatusRequest $request)
    {
        $settings = (object) config('site.settings_vacancy');
        Vacancy::where('id', $request->id)
            ->update([
                'job_posting'=>[
                    'status_name'=>$settings->job_status[$request->index],
                    'create_time'=>now(),
                ],
            ]);

        return $this->getResponse();
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
