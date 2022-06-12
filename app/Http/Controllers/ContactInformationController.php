<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactInformation\UpdateContactRequest;
use App\Model\UserCompany;
use App\Model\UserContact;
use App\Repositories\ContactInformationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactInformationController extends BaseController
{
    protected $repository;

    public function __construct() {
        parent::__construct();
        $this->repository = new ContactInformationRepository();
    }

    // поля редактирования
    public function index()
    {
        $settings = $this->getSettings();
        $contact = UserContact::where('user_id', Auth::user()->id)
            ->with('position','avatar')->first();

        return view('contact_information', compact('contact','settings'));
    }

    public function update(UpdateContactRequest $request)
    {
        $bool = $this->repository->updateContact($request);
        return $this->getResponse($bool);
    }

    private function getSettings(){
        $settings = config('site.contacts');

        return $settings;
    }
}
