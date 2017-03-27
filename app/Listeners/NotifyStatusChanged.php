<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderStatusChangedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyStatusChanged
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
     * @param  OrderStatusChanged  $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        if($event->order->belongsToUser()){
            $email = $event->order->user->email;
        }else{
            $email = $event->order->email;
        }

        Mail::to($email)->queue(new OrderStatusChangedMail([
            'order' => $event->order,
            'comment' => $event->comment,
        ]));
    }

    public function failed(OrderStatusChanged $event, $exception)
    {
        throw $exception;
    }
}
