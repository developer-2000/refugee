<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendActivateAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    public $tries=3;

    /**
     * Create a new job instance.
     *
     * @param $validated
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $config = config('site.feedback');

        // клиенту
        Mail::send('emails.activate', [], function($message) use ($config) {
            $message->to($this->email)
                ->from($config['service_errors']['email'], "Work-es-ua")
                ->subject("Activation Account");
        });
    }

}
