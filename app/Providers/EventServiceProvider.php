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
            'App\Listeners\NotifyOrderPlaced',
            'App\Listeners\NotifyCompanyNewOrder',
        ],
        'App\Events\OrderStatusChanged' => [
            'App\Listeners\NotifyStatusChanged',
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
