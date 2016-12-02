<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'email' => 'required|email', 
            'subject' => 'required', 
            'body' => 'required'
        ]);

        Mail::to(config('mail')['from']['address'])->send(new ContactEmail([
            'email' => $request['email'],
            'subject' => $request['subject'],
            'body' => $request['body'],
        ]));

        return response()->json([], 201);
    }
}
