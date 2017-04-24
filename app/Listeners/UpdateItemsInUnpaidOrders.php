<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\ProductsToggled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateItemsInUnpaidOrders
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
     * @param  ProductsDisabled  $event
     * @return void
     */
    public function handle(ProductsToggled $event)
    {
        foreach ($event->products as $product) {
            // Find all unpaid orders that have items linked to the toggled product.
            $orders = Order::unpaid()->whereHas('items', function ($q) use ($product) {
                $q->where('product_id',$product->id);
            })->get();

            // If there are any such orders, then for each one toggle the items linked
            // to the toggled product and calculate the order's pricing once again.
            //  If there aren't any available items left, then cancel the order.
            if ($orders->count() > 0) {
                foreach ($orders as $order) {

                    if($product->is_active) {
                        $order->items()->where('product_id',$product->id)->get()->each->enable();
                    }else {
                        $order->items()->where('product_id',$product->id)->get()->each->disable();
                    }

                    $order->calculatePricing();
                    
                    if($order->availableItems()->count() == 0) {
                        $order->cancel();
                    }
                }
            }
        }
    }
}
