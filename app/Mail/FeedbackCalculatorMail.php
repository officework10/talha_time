<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackCalculatorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $messageText;
    public $calName;

    public function __construct($name, $email, $messageText, $calName)
    {
        $this->name = $name;
        $this->email = $email;
        $this->messageText = $messageText;
        $this->calName = $calName;
    }

    public function build()
    {
        return $this->subject('New Calculator Feedback')
            ->view('emails.feedback');
    }
}
