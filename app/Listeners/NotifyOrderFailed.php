<?php

namespace App\Listeners;

use App\Mail\OrderFailedMail;
use App\Models\RegisterToken;
use App\Events\OrderPaymentFailed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyOrderFailed
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
        if($event->order->belongsToUser()){
            $email = $event->order->user->email;
            $token = null;
        }else{
            $email = $event->order->email;
            $token = RegisterToken::generateFor($email);
        }

        Mail::to($email)->queue(new OrderFailedMail([
            'order' => $event->order,
            'token' => $token,
        ]));
    }
}
