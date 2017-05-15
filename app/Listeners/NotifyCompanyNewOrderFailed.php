<?php

namespace App\Listeners;

use App\Mail\NewOrderFailedMail;
use App\Events\OrderPaymentFailed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCompanyNewOrderFailed implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaymentFailed  $event
     * @return void
     */
    public function handle(OrderPaymentFailed $event)
    {
        Mail::to(config('mail.new-orders.address'))->queue(new NewOrderFailedMail($event->order));
    }
}
