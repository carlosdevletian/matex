<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Design;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        if($order->email == session('email')){
            return view('orders.show', compact('order'));
        }else{
            $this->authorize('show', $order);
            return view('orders.show', compact('order'));
        }
    }

    public function create($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();


        if(auth()->check()) {
            $addresses = Address::where('user_id', auth()->user()->id)->get();
            $design = Design::findOrFail(session('design'));
            
            return view('orders.create', ['products' => $products, 'addresses' => $addresses, 'design' => $design->id, 'design_image' => $design->image_name]);
        }
        $addresses = collect();

        return view('orders.create', ['products' => $products, 'addresses' => $addresses, 'design' => session('design'), 'design_image' => session('design')]);
    }

    public function store()
    {
        // comments del usuario en alguna parte

        // asociar la orden a un usuario o guest
        if(auth()->check()){
            $order = Order::create([
               'user_id' => auth()->user()->id,
               'address_id' => request()->address_id
            ]);
        }else{
            $address = Address::findOrFail(request()->address_id);
            $order = Order::create([
               'email' => $address->email,
               'address_id' => $address->id,
            ]);
            session(['email' => $order->email]);
        }

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
            if(!auth()->check()){
                $item->design->email = $order->email;
                $item->design->save();
                $item->design->move();
            }
        }

        $order->assignReferenceNumber();
        $order->calculatePricing();
        $order->save();

        // PAGAR

        return response()->json(['order' => $order], 200);
    }
}
