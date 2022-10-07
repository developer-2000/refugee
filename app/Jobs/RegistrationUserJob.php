<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RegistrationUserJob extends EmailBaseJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title_subject='';
    protected $email='';

    public $tries=3;

    /**
     * lotokvest@gmail.com
     * @param $data
     */
    public function __construct($data) {
        parent::__construct();

        $this->data["welcome"] = __('email.welcome');
        $this->data["to_complete_registration"] = __('email.to_complete_registration');
        $this->data["url"] = $data["url"];
        $this->email = $data["email"];
        $this->title_subject = $data["title_subject"];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $config = config('site.feedback');
        // клиенту
        Mail::send('emails.registration', ["data"=>$this->data], function ($message) use ($config) {
            $message->to($this->email)
                ->from($config['main_questions']['email'], env('APP_DOMAIN', 'Laravel'))
                ->subject($this->title_subject);
        });
    }

}
