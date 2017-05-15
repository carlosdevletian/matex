<?php

namespace App\Mail;

use Dompdf\Dompdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Mail\Traits\CreatesPdfs;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderFailedMail extends Mailable
{
    use Queueable, SerializesModels, CreatesPdfs;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        $designs = $this->order->items->map(function ($item) {
            return $item->design;
        })->unique(function ($design) {
            return $design->id;
        });

        $mail = $this->from(config('mail.new-orders'))
                    ->markdown('emails.new-order')
                    ->subject('A new order has been placed')
                    ->with([
                        'order' => $this->order, 
                        'items' => $items,
                        'orderUrl' => route('orders.show', $this->order->reference_number)
                    ]);

        foreach ($designs as $design) {
            $mail->attach($design->getImagePath(), [
                  'as' => $design->image_name
            ]);
            // $mail->attachData($this->createPDF($design), $this->setAttachmentName($design));
        }
        return $mail;
    }
}
