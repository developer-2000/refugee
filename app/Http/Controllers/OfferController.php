<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\AddMessageRequest;
use App\Http\Requests\Offer\IndexOfferRequest;
use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Model\Offer;
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

    public function show(Offer $offer)
    {   // настройки содержимого контакт листа
        $settings['contact_information'] = config('site.contacts.contact_information');
        $offer = $this->repository->show($offer->id);

        return view('offer.show_offer', compact('offer', 'settings'));
    }

    public function addMessage(AddMessageRequest $request)
    {
        $last_chat = $this->repository->addMessage($request);

        return $this->getResponse($last_chat);
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
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Model\Offer  $offer
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Offer $offer)
//    {
//        //
//    }

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
