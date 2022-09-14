<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RespondVacancyResumeJob extends EmailBaseJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries=3;

    /**
     * email кому написали
     * имя написавшего
     * заголовок чата
     * ссылка на чат
     * заголовок документа предложения
     * ссылка документа предложени
     * текст чата
     *
     * @param $arr
     */
    public function __construct($arr) {
        parent::__construct();

        $this->data["chat_interlocutor"] = __('email.chat_interlocutor');
        $this->data["you_have_review_document"] = __('email.you_have_review_document');
        $this->data["title_subject"] = __('email.message_from');

        $this->data["email_respond"] = $arr["email_respond"];
        $this->data["full_name_person_write"] = $arr["full_name_person_write"];
        $this->data["chat_title"] = $arr["chat_title"];
        $this->data["chat_link"] = $arr["chat_link"];
        $this->data["offer_document_title"] = $arr["offer_document_title"];
        $this->data["offer_document_link"] = $arr["offer_document_link"];
        $this->data["chat_text"] = $arr["chat_text"];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        $config = config('site.feedback');

        // клиенту
        Mail::send('emails.respond_vacancy_resume', ["data"=>$this->data], function($message) use ($config) {
            $message->to($this->data["email_respond"])
                ->from($config['main_questions']['email'], "Work-es-ua")
                ->subject($this->data["title_subject"].$this->data["full_name_person_write"]);
        });
    }

}
