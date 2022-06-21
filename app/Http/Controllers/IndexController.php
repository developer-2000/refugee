<?php
namespace App\Http\Controllers;


use App\Http\Requests\Vacancy\JobSearchRequest;
use App\Model\Image;
use App\Model\Position;
use App\Model\Test;
use App\Model\Vacancy;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index(Request $request) {
//        $offerRepository = new OfferRepository();
//
//        $message = [
//            "my_offer_title"=>"title1",
//            "my_offer_url"=>"alias1",
//            "your_offer_title"=>"title2",
//            "your_offer_url"=>"alias2",
//            "covering_letter"=>"",
//        ];
//
//        $offer = $offerRepository->getOffer(1, 1);
//
//        // 2.1 обновить существующий
//        if($offer){
//            $chat = $offer->chat;
//            $chat[] = $message;
//            $offer->chat = $chat;
//            $offer->save();
//        }
//        // 2.2 создать новый
//        else{
//            $chat = $offerRepository->create(1, 1, $message);
//        }

        return view('index');
    }

}
