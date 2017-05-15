<?php

namespace App\Listeners;

use App\Mail\NewOrderMail;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCompanyNewOrder implements ShouldQueue
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
     * @param  OrderPlaced  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to(config('mail.new-orders.address'))->queue(new NewOrderMail($event->order));
    }
}
