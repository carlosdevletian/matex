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
        // dd(request()->toArray());

        // comments del usuario en alguna parte
    
        $order = Order::create([
           'address_id' => request()->address_id
        ]);

        foreach(request()->items as $itemData){
            if($itemData['quantity'] > 0) {
                $item = Item::create([
                     'order_id' => $order->id,
                     'product_id' => $itemData['product_id'],
                     'design_id' => $itemData['design_id'],
                     'quantity' => $itemData['quantity'],
                     'unit_price' => $itemData['unit_price'],
                     'total_price' => $itemData['total_price']
                ]);
                // $item->removeFromCart();
                // calcular el precio del item: tanto unitario como precio total
                // ¿Colocar el precio que viene desde el front-end o calcularlo de nuevo? -> $item->assignPrice();
            }
        }

        // asociar la orden a un usuario o guest
        // crear un reference_number
        // calcular subtotal, shipping, etc o traerlo del front-end

        // PAGAR

        return response()->json(['order' => $order], 200);

    }
}
