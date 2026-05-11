<?php

 namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function feedback(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required|string',
            'message' => 'required|string',
        ]);
        $userData = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'sms' => $request->input('message'),
        ];
        // Send email
        Mail::send('email/contact', [
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'subject' => 'Feedback thetime-calculator.com '.$request->calc_name,
            'comment' => $request->input('message'), ],
            function ($message) use($request){
                $message->from('technicalcalculators@gmail.com', $request->calc_name);
                $message->to('technicalcalculators@gmail.com');
                $message->replyTo($request->email)
                ->subject('thetime-calculator.com Feedback Form '.$request->calc_name);
            }
        );
        // Mail::send('feedback', $userData, function ($message) use ($request) {
        // // dd('s');
        //     $message->from('technicalcalculators@gmail.com', 'calculator-');
        //     $message->to('technicalcalculators@gmail.com');
        //     $message->replyTo($request->email)
        //         ->subject('feedback form (calculator-age.com)');
        // });
        return response()->json(['message' => 'Form submitted successfully']);
    }
}
