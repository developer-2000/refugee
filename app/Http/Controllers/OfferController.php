<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\IndexOfferRequest;
use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;


class OfferController extends BaseController {

    protected $repository;

    public function __construct() {
//        parent::__construct();
        $this->repository = new OfferRepository();
    }

    /**
     * вывод всех моих чатов
     * @param  IndexOfferRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IndexOfferRequest $request)
    {
        $offers = $this->repository->index($request);
        // настройки содержимого контакт листа
        $settings['contact_information'] = config('site.contacts.contact_information');

        return view('offer.index_offer', compact('offers', 'settings'));
    }

    /**
     * найти среди моих чатов искомое имя или должность
     * @param  SearchPositionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchNamePosition(SearchPositionRequest $request)
    {
        $arraySearch = $this->repository->searchNamePosition($request);

        return $this->getResponse(compact('arraySearch'));
    }


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
//     * @param  \App\Model\Offer  $offer
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Offer $offer)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Model\Offer  $offer
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Offer $offer)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Model\Offer  $offer
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, Offer $offer)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Model\Offer  $offer
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Offer $offer)
//    {
//        //
//    }
}
