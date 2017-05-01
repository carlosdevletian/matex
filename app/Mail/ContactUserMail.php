<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.customer-support'))
                    ->subject("Message from Matex - '{$this->request['subject']}'")
                    ->replyTo(config('mail.customer-support'))
                    ->markdown('emails.contactUser')
                    ->with([
                       'subject' => $this->request['subject'],
                       'body' => $this->request['body']
                    ]);
    }
}
