<?php

namespace App\Livewire\Feedback;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\FeedbackCalculatorMail;

class CalculatorFeedback extends Component
{
    public $name;
    public $email;
    public $message;
    public $calName = null;
    public $showSuccess = false;
    public function submit()
    {
        $this->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'message' => 'required|string|min:5',
        ]);

        Mail::to(env('CEO_EMAIL'))->send(new FeedbackCalculatorMail(
            $this->name,
            $this->email,
            $this->message,
            $this->calName
        ));

        $this->dispatch('toast', message: __('menu_lang.feedback_success_message'));
        $this->reset(['name', 'email', 'message']);
    }

    public function render()
    {
        return view('livewire.feedback.calculator-feedback');
    }
}
