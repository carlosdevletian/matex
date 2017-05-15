<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OrderPlaced' => [
            'App\Listeners\UpdateApprovedOrder',
            'App\Listeners\NotifyOrderPlaced',
            'App\Listeners\NotifyCompanyNewOrder',
        ],
        'App\Events\OrderPaymentFailed' => [
            'App\Listeners\UpdateFailedOrder',
            'App\Listeners\NotifyOrderFailed',
            'App\Listeners\NotifyCompanyNewOrderFailed',
        ],
        'App\Events\OrderStatusChanged' => [
            'App\Listeners\NotifyStatusChanged',
        ],
        'App\Events\ProductsToggled' => [
            'App\Listeners\UpdateItemsInUnpaidOrders',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
