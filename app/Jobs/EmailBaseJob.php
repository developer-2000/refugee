<?php
namespace App\Jobs;

use App\Model\Test;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;

class EmailBaseJob {

    public $data;

    public function __construct() {
        $service = new LanguageService();
        App::setLocale($service->selectLangFromUrl());

        $this->data = [
            "title_site" => __('email.title_site'),
            "thank_you_choosing" => __('email.thank_you_choosing'),
            "if_you_have_questions" => __('email.if_you_have_questions'),
            "support_center" => __('email.support_center'),
            // /ru/
            "lang_url" => session('prefix_lang'),
            "domain" => env('APP_URL'),
        ];
    }
}
