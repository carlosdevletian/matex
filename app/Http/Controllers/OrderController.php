<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Design;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $this->authorize('show', $order);
        return view('orders.show', compact('order'));
    }

    public function create($categoryId, Design $design)
    {
        return view('orders.create', compact('categoryId','design'));
    }

    public function store()
    {
        // comments del usuario en alguna parte
    
        // asociar la orden a un usuario o guest
        $order = Order::create([
           'user_id' => auth()->user()->id,
           'address_id' => request()->address_id
        ]);

        foreach(request()->items as $itemData){
            if($itemData['quantity'] > 0) {
                $item = new Item;
                $item->order_id = $order->id;
                $item->product_id = $itemData['product_id'];
                $item->design_id = $itemData['design_id'];
                $item->quantity = $itemData['quantity'];

                $item->calculatePricing();
                $item->save();
                // $item->removeFromCart();
            }
        }

        $order->assignReferenceNumber();
        $order->calculatePricing();
        $order->save();

        // PAGAR

        return response()->json(['order' => $order], 200);
    }
}
