<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomer implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        if($event->order->belongsToUser()){
            var_dump('epa');
            $email = $event->order->user->email;
            var_dump($email);
        }else{
            $email = $event->order->email;
        }

        Mail::to($email)->queue(new OrderPlacedMail([
            'order' => $event->order,
        ]));
    }

    public function failed(OrderPlaced $event, $exception)
    {
        throw $exception;
    }
}
