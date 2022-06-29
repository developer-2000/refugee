<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\AddMessageRequest;
use App\Http\Requests\Offer\DeleteElementRequest;
use App\Http\Requests\Offer\IndexOfferRequest;
use App\Http\Requests\Offer\RegisterViewedRequest;
use App\Http\Requests\Offer\SendToArchiveRequest;
use App\Http\Requests\Offer\UpdateMessageRequest;
use App\Http\Requests\Vacancy\SearchPositionRequest;
use App\Model\Offer;
use App\Model\OfferChatArchive;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $count_archive = OfferChatArchive::where('one_user_id', Auth::user()->id)
            ->orWhere('two_user_id', Auth::user()->id)->count();

        return view('offer.index_offer', compact('offers', 'settings', 'count_archive'));
    }

    /**
     * просмотр чата по id
     * @param  Offer  $offer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Offer $offer)
    {   // настройки содержимого контакт листа
        $settings['contact_information'] = config('site.contacts.contact_information');
        $offer = $this->repository->show($offer->id);

        return view('offer.show_offer', compact('offer', 'settings'));
    }

    public function destroy(DeleteElementRequest $request)
    {
        $offer = $this->repository->destroy($request);

        return $this->getResponse();
    }

    public function sendToArchive(SendToArchiveRequest $request)
    {
        $array = $this->repository->sendToArchive($request);
        if(!$array[0]){
            return $this->getErrorResponse($array[1]);
        }

        return $this->getResponse($array[0]);
    }

    public function addMessage(AddMessageRequest $request)
    {
        $last_chat = $this->repository->addMessage($request);

        return $this->getResponse($last_chat);
    }

    /**
     * обновисть сообщение в чате
     * @param  AddMessageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMessage(UpdateMessageRequest $request)
    {
        $array = $this->repository->updateMessage($request);
        if(!$array[0]){
            return $this->getErrorResponse($array[1]);
        }

        return $this->getResponse($array[0]);
    }

    public function registerViewedCompanion(RegisterViewedRequest $request)
    {
        $bool = $this->repository->registerViewedCompanion($request);

        return $this->getResponse($bool);
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






}
