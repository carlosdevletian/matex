<?php

namespace App\Mail;

use Dompdf\Dompdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

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

    private function createPDF($design)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml("
            <img src='{$design->getImagePath()}' width='100%'>
            <br>
            <h1>{$design->comment}</h1>
        ");
        $dompdf->render();
        return $dompdf->output();
    }

    private function setAttachmentName($design)
    {
        return substr($design->image_name, 0, -3) . 'pdf';
    }
}
