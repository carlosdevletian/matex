<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Design;
use App\Models\Order;
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
        // dd(request()->toArray());

        $design = Design::findOrFail(request()->design_id);

        if(request()->has('comments')) {
            $design->comment = request()->comments;
            $design->save();
        }
    
        $order = Order::create();
        dd($order);

        foreach(request()->items as $product => $quantity){
            if($quantity > 0) {
                $item = Item::create([
                     'order_id' => $order->id,
                     'product_id' => $product,
                     'design_id' => request()->design_id,
                     'quantity' => $quantity,
                ]);
                // calcular el precio del item: tanto unitario como precio total
                $item->assignPrice();

            }
        }


        // return

    }
}
