<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlacedMail;
use App\Models\RegisterToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyOrderPlaced implements ShouldQueue
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
        if($event->order->belongsToUser()){
            $email = $event->order->user->email;
            $token = null;
        }else{
            $email = $event->order->email;
            $token = RegisterToken::generateFor($email);
        }

        Mail::to($email)->queue(new OrderPlacedMail([
            'order' => $event->order,
            'token' => $token,
        ]));
    }

    public function failed(OrderPlaced $event, $exception)
    {
        throw $exception;
    }
}
