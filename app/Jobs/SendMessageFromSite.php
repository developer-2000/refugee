<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMessageFromSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validated;

    public $tries=3;

    /**
     * Create a new job instance.
     *
     * @param $validated
     */
    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        $config = config('site.feedback');
        $text = "Пользователь ".$this->validated['full_name'].", с Email - ".$this->validated['email'].", отправил письмо с сайта <br>".$this->validated['text'];

        // отправка мне
        Mail::send('emails.message_feedback', ['text' => $text], function($message) use ($config) {
            $message->to($config[$this->validated['subject']]['email'])->from($this->validated['email'], "Work-es-ua")->subject($this->validated['subject']);
        });

        $text = "Привет ".$this->validated['full_name'].". <br><br>";
        $text .= "Благодарим Вас за обращение в Work-es-ua.com Мы получили ваше сообщение и свяжемся с вами как можно скорее. Чтобы добавить дополнительные комментарии, вы можете ответить на это письмо.";
        $text .= "<br><br>Спасибо, <br>Команда Work-es-ua.com";

        // отправка отправителю
        Mail::send('emails.message_feedback', ['text' => $text], function($message) use ($config) {
            $message->to($this->validated['email'])->from($config[$this->validated['subject']]['email'], "Work-es-ua")->subject("Work-es-ua");
        });

    }
}
