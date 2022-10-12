<?php

namespace App\Jobs;

use App\Model\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CustomerSurveyJob extends EmailBaseJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $comment;
    protected $text;
    protected $subject;

    public $tries=3;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data) {
        parent::__construct();

        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->comment = $data['comment'];
        $this->text = $data['text'];
        $this->subject = "Опрос улучшений";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $config = config('site.feedback');

        Mail::send('emails.customer_survey', [
            'text' => $this->text,
            'comment' => $this->comment,
            'email' => $this->email,
            'name' => $this->name,
            ],
            function($message) use ($config) {
            $message->to($config['main_questions']['email'])
                ->from($this->email, env('APP_DOMAIN', 'Laravel'))
                ->subject($this->subject);
        });

    }
}
