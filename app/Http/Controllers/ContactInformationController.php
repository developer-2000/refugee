<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Requests\ContactInformation\StoreContactRequest;
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
        $this->repository = new ContactInformationRepository();
    }

    public function index()
    {
        $settings = $this->getSettings();
        $contact = UserContact::where('user_id', Auth::user()->id)
            ->with('position')->first();

        return view('contact_information', compact('contact','settings'));
    }

    public function store(StoreContactRequest $request)
    {
        $store = $this->repository->storeContact($request);
        return $this->getResponse();
    }

    public function update(UpdateContactRequest $request)
    {
        $bool = $this->repository->updateContact($request);
        return $this->getResponse($request->validated());
    }

    private function getSettings(){
        $settings = config('site.contacts');

        return $settings;
    }
}
