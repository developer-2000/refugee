<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackMessage extends EmailBaseJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validated;
    protected $subject;
    protected $title_subject = '';

    public $tries=3;

    /**
     * Create a new job instance.
     *
     * @param $validated
     */
    public function __construct($validated) {
        parent::__construct();

        $this->data["we_greet_you"] = __('email.we_greet_you');
        $this->data["we_have_received"] = __('email.we_have_received');
        $this->data["full_name"] = $validated['full_name'];
        $this->data["text"] = $validated['text'];
        $this->title_subject  = __('email.feedback');
        $this->validated = $validated;
        $this->subject = [
            'main_questions'=> "Основные вопросы",
            'partnerships'=>"Партнерские отношения",
            'service_errors'=>"Ошибки в работе сервиса",
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $config = config('site.feedback');

        // 1 админу __('meta_tags.feedback.title')
        $text = $this->validated['full_name']."( ".$this->validated['email']." ) отправил(а) письмо с сайта <br>".$this->validated['text'];
        Mail::send('emails.admin_feedback', ['text' => $text], function($message) use ($config) {
            $message->to($config[$this->validated['subject']]['email'])
                ->from($this->validated['email'], "Work-es-ua")
                ->subject($this->title_subject.$this->validated['full_name']);

        });

        // 2 отправителю
        Mail::send('emails.message_feedback', ["data"=>$this->data], function($message) use ($config) {
            $message->to($this->validated['email'])
                ->from($config[$this->validated['subject']]['email'], "Work-es-ua")
                ->subject($this->title_subject.$this->validated['full_name']);
        });

    }
}
