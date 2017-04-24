<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusChangedMail extends Mailable
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
        return $this->view('emails.order')
                    ->subject('Order # '. $this->data['order']->reference_number . ' now has the status: ' . $this->data['order']->status->name)
                    ->with(['order' => $this->data['order'], 
                           'comment' => $this->data['comment'],
                           'shipping' => $this->data['shipping'],
                           ]);
    }
}
