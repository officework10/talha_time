<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $subjectLine, $msg;

    public function __construct($name, $email, $subjectLine, $msg)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subjectLine = $subjectLine;
        $this->msg = $msg;
    }

    public function build()
    {
        return $this->subject('New Feedback Received')
            ->view('emails.feedback-form');
    }
}
