<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Mail\ContactUserMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request) {
        if(auth()->check()) {
            $this->validate($request, [
                'email' => ['required', Rule::exists('users')->where(function ($query) {
                                $query->where('email', auth()->user()->email);
                            }),] 
            ]);
        }
        $this->validate($request, [
            'email' => 'required|email', 
            'subject' => 'required', 
            'body' => 'required'
        ]);

        Mail::to(config('mail.customer-support.address'))
                ->queue(new ContactEmail($request->toArray()));

        return response()->json([], 201);
    }

    public function contactUser(Request $request) {
        $this->validate($request, [
            'email' => 'required|email', 
            'subject' => 'required', 
            'body' => 'required'
        ]);

        Mail::to($request->email)
                ->queue(new ContactUserMail($request->toArray()));

        return response()->json([], 201);
    }
}
