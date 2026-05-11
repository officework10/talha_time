<?php

namespace App\Livewire\Feedback;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackFormMail;

class FeedbackForm extends Component
{
    public $name, $email, $subject, $msg;
    public $isSending = false;

    public function send()
    {
        $this->isSending = true;

        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'msg' => 'required|min:20|max:2000',
        ]);

        Mail::to(env('CEO_EMAIL'))->send(new \App\Mail\FeedbackFormMail(
            $this->name,
            $this->email,
            $this->subject,
            $this->msg
        ));

        $this->reset(['name', 'email', 'subject', 'msg']);
        $this->dispatch('toast', message: __('menu_lang.feedback_success_message'));
        $this->dispatch('scroll-to-top');

        $this->isSending = false;
    }

    public function render()
    {
        return view('livewire.feedback.feedback-form');
    }
}
