<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendActivateAccount extends EmailBaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $title_subject;

    public $tries=3;

    /**
     * Create a new job instance.
     *
     * @param $email
     */
    public function __construct($email) {
        parent::__construct();

        $this->email = $email;
        $this->title_subject = __('email.account_activation');
        $this->data["your_account_activated"] = __('email.your_account_activated');
        $this->data["you_change_your_password"] = __('email.you_change_your_password');
        $this->data["change_your_password"] = __('email.change_your_password');
        $this->data["to_work_effectively"] = __('email.to_work_effectively');
        $this->data["employer_and_employee"] = __('email.employer_and_employee');
        $this->data["personal_information"] = __('email.personal_information');
        $this->data["for_the_employer"] = __('email.for_the_employer');
        $this->data["my_company_information"] = __('email.my_company_information');
        $this->data["start_creating_offers"] = __('email.start_creating_offers');
        $this->data["create_job"] = __('email.create_job');
        $this->data["for_employee"] = __('email.for_employee');
        $this->data["create_resume"] = __('email.create_resume');

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $config = config('site.feedback');

        // клиенту
        Mail::send('emails.activate', ["data"=>$this->data], function($message) use ($config) {
            $message->to($this->email)
                ->from($config['main_questions']['email'], env('APP_DOMAIN', 'Laravel'))
                ->subject($this->title_subject);
        });
    }

}
