<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    private $order;
    private $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $comment)
    {
        $this->order = $order;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $items = $this->order->items()->get()->groupBy(function ($item) {
            return $item->design->image_name;
        });

        return $this->from(config('mail.customer-support'))
                    ->markdown('emails.statusChanged')
                    ->subject("Your Matex order has been updated - '{$this->order->status->name}'")
                    ->with([
                           'order' => $this->order, 
                           'comment' => $this->comment,
                           'items' => $items,
                           'orderUrl' => route('orders.show', $this->order->reference_number)
                        ]);
    }
}
