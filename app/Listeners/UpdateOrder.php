<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrder implements ShouldQueue
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
    public function handle(OrderPlaced $event)
    {
        if(! isset($event->charge)) return;
        $event->order->setStatus('Payment Approved');
        $event->order->update([
            'card_last_four' => $event->charge->cardLastFour()
        ]);
    }
}
