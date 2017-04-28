<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.customer-support'))
                    ->markdown('emails.contact')
                    ->subject("Message from User - '{$this->data['subject']}'")
                    ->replyTo($this->data['email'])
                    ->with([
                        'subject' => $this->data['subject'],
                        'userEmail' => $this->data['email'],
                        'body' => $this->data['body'],
                    ]);
    }
}
