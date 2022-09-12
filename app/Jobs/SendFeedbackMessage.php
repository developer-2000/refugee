<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validated;
    protected $subject;

    public $tries=3;

    /**
     * Create a new job instance.
     *
     * @param $validated
     */
    public function __construct($validated)
    {
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
        $text = $this->validated['full_name']."( ".$this->validated['email']." ) отправил(а) письмо с сайта <br>".$this->validated['text'];

        // 1 админу __('meta_tags.feedback.title')
        Mail::send('emails.admin_feedback', ['text' => $text], function($message) use ($config) {
            $message->to($config[$this->validated['subject']]['email'])
                ->from($this->validated['email'], "Work-es-ua")
                ->subject($this->subject[$this->validated['subject']]);
        });

        $text = "Привет ".$this->validated['full_name'].". <br><br>";
        $text .= "Благодарим Вас за обращение в Work-es-ua.com Мы получили ваше сообщение и свяжемся с вами как можно скорее. Чтобы добавить дополнительные комментарии, вы можете ответить на это письмо.";
        $text .= "<br><br>Спасибо, <br>Команда Work-es-ua.com";

        // 2 отправителю
        Mail::send('emails.message_feedback', ['text' => $text], function($message) use ($config) {
            $message->to($this->validated['email'])
                ->from($config[$this->validated['subject']]['email'], "Work-es-ua")
                ->subject("Обратная связь");
        });

    }
}
