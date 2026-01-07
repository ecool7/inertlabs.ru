<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $mailTo = env('MAIL_TO', 'info@inertlabs.ru');
        
        try {
            Mail::raw(
                "Имя: {$request->name}\nEmail: {$request->email}\n\nСообщение:\n{$request->message}",
                function ($message) use ($request, $mailTo) {
                    $message->to($mailTo)
                        ->subject("Новая заявка с сайта Inertlab от {$request->name}");
                }
            );
            
            return back()->with('success', 'Спасибо! Ваше сообщение отправлено. Мы свяжемся с вами в ближайшее время.');
        } catch (\Exception $e) {
            return back()->with('error', 'Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте позже или напишите на info@inertlabs.ru');
        }
    }
}
