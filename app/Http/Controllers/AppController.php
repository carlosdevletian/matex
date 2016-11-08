<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppController extends Controller
{
    public function contact(Request $request){
        $this->validate($request, ['email' => 'required|email', 'subject' => 'required', 'body' => 'required']);

        Mail::to(config('mail')['from']['address'])->send(new ContactEmail([
            'email' => $request['email'],
            'subject' => $request['subject'],
            'body' => $request['body'],
        ]));

        flash()->success('Muchas gracias', 'El correo fue enviado exitosamente');

        return redirect()->back();
    }
}
