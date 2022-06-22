<?php

namespace App\Http\Controllers;

use App\Model\Offer;
use App\Repositories\CompanyRepository;
use App\Repositories\ContactInformationRepository;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends BaseController {

    protected $repository;

    public function __construct() {
//        parent::__construct();
        $this->repository = new OfferRepository();
    }

    public function index()
    {
        $my_id = Auth::user()->id;
//        $offers = $this->repository->getIndexPage();
        // 1 настройки содержимого контакт листа
        $settings['contact_information'] = config('site.contacts.contact_information');

        // 2 выбрать все мои чаты с контактами собеседника
        $offers = Offer::where('one_user_id', Auth::user()->id)
            ->orWhere('two_user_id', Auth::user()->id)
            ->with(["contact_one_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_one_user.avatar","contact_one_user.position"])
            ->with(["contact_two_user" => function($q) use($my_id){
                $q->where('user_id', '!=', $my_id);
            },"contact_two_user.avatar","contact_two_user.position"])
            ->get();

        // 3 внести в каждый чат контакт лист своего собеседника
        $offers->each(function ($item, $key) {
            if(!is_null($item->contact_one_user)){
                $item->contact_list = (new ContactInformationRepository())->fillContactList(
                    $item->contact_one_user, $item->contact_one_user->user_id
                );
            }
            elseif(!is_null($item->contact_two_user)){
                $item->contact_list = (new ContactInformationRepository())->fillContactList(
                    $item->contact_two_user, $item->contact_two_user->user_id
                );
            }
        });

//        dd($offers->toArray());

        return view('offer.index_offer', compact('offers', 'settings'));
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
