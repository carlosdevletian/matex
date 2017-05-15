<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderFailedMail extends Mailable
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
        $items = $this->data['order']->items()->get()->groupBy(function ($item) {
            return $item->design->image_name;
        });
        if(isset($this->data['token'])) {
            $orderUrl = route('orders.show', [
                'order' => $this->data['order']->reference_number, 
                'token' => $this->data['token']
            ]);
        } else {
            $orderUrl = route('orders.show', $this->data['order']->reference_number);
        }
        return $this->from(config('mail.new-orders'))
                    ->markdown('emails.order')
                    ->subject('Order # '. $this->data['order']->reference_number . ' has been placed')
                    ->with([
                           'order' => $this->data['order'], 
                           'token' => $this->data['token'],
                           'items' => $items,
                           'orderUrl' => $orderUrl,
                           'registerUrl' => route('register.client', $this->data['token'])
                       ]);
    }
}
