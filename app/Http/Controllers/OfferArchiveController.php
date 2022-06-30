<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferArchive\AddMessageArchiveRequest;
use App\Repositories\OfferArchiveRepository;
use Illuminate\Http\Request;

class OfferArchiveController extends BaseController {

    protected $repository;

    public function __construct() {
//        parent::__construct();
        $this->repository = new OfferArchiveRepository();
    }

    public function index(Request $request)
    {
        $offers = $this->repository->index($request);
        // настройки содержимого контакт листа
        $settings['contact_information'] = config('site.contacts.contact_information');
        $count_archive = 0;

        return view('offer.index_offer', [
            'respond' => [
                'table'=>'archive',
                'offers'=>$offers,
                'settings'=>$settings,
                'count_archive'=>$count_archive,
            ]
        ]);
    }

    public function show($alias) {
        // настройки содержимого контакт листа
        $settings['contact_information'] = config('site.contacts.contact_information');
        $offer = $this->repository->show($alias);

        return view('offer.show_offer', [
            'respond' => [
                'table'=>'archive',
                'offer'=>$offer,
                'settings'=>$settings,
            ]
        ]);
    }

    public function addMessage(AddMessageArchiveRequest $request)
    {
        $last_chat = $this->repository->addMessage($request);
        return $this->getResponse();
    }

}
