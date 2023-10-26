<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    private $contact;

    public function __construct(Contact $c)
    {
        $this->contact = $c;
    }


    public function sendMessage(Request $request)
    {
        $this->validate($request, $this->contact->rules, $this->messages());

        $dataForm = [
            'name' => $request['name'],
            'email' => $request['email'],
            'subject' => $request['subject'],
            'msg' => $request['message'],
            'from' => "Contato LEB - Mensagem de " . $request['name'],
        ];

        Mail::send('layouts/email-template', $dataForm, function ($message) use ($dataForm) {
            $message->from(env('MAIL_USERNAME'), $dataForm['from']);
            $message->to(env('EMAIL_CONTATO'));
            $message->subject($dataForm['subject']);
        });

        return redirect('/');
    }

    public function messages()
    {
        return [
            'name.required' => 'Por favor insira o seu nome.',
            'email.required' => 'Por favor insira seu email.',
            'email.email' => 'Por favor insira um email válido.',
            'subject.required' => 'A mensagem deve conter um assunto.',
            'message.required' => 'O conteúdo da mensagem não pode estar vazio.',
        ];
    }
}
