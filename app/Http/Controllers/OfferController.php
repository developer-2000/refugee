<?php

namespace App\Http\Controllers;

use App\Model\Offer;
use App\Repositories\CompanyRepository;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;

class OfferController extends BaseController {

    protected $repository;

    public function __construct() {
//        parent::__construct();
        $this->repository = new OfferRepository();
    }

    public function index()
    {
        $offers = $this->repository->getMyOffers();

        return view('offer.index_offer', compact('offers'));
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
