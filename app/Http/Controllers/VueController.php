<?php

namespace App\Http\Controllers;

use App\Calculator;
use App\Models\Item;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;

class VueController extends Controller
{
    public function addToCart()
    {
        $items = collect(request()->toArray());
        $cartId = auth()->user()->cart->id;
        $items->map(function($item) use($cartId){
            $item['cart_id'] = $cartId;
            return Item::create($item);
        });
    }

    public function calculatePrice()
    {
        $calculator = new Calculator();
        $unitPrice = $calculator->unitPrice(request()->product['id'], request()->design_id, request()->quantity);
        $totalPrice = $calculator->totalPrice(request()->quantity, $unitPrice);
        return response()->json(['unit_price' => $unitPrice, 'total_price' => $totalPrice], 200);
    }

    public function calculateShipping()
    {
        $calculator = new Calculator();
        $shipping = $calculator->shipping(request()->zip);
        return response()->json(['shipping' => $shipping], 200);
    }

    public function calculateTax()
    {
        $calculator = new Calculator();
        $taxPercentage = $calculator->tax(request()->zip);
        return response()->json(['tax_percentage' => $taxPercentage], 200);
    }

    public function prepareOrder()
    {
        if(auth()->check()) {
            if(request()->selectedAddress != 0){
                $address = Address::findOrFail($request()->selectedAddress);
            }else {
                $this->validate(request(), [
                'newAddress.email' => 'required|email',
                'newAddress.name' => 'required',
                'newAddress.street' => 'required',
                'newAddress.city' => 'required',
                'newAddress.zip' => 'required',
                'newAddress.country' => 'required',
                'newAddress.phone_number' => 'required',
                ]);
                $addressData = request()->except(['newAddress.is_valid', 'newAddress.show_errors'])['newAddress'];
                $addressData['user_id'] = auth()->user()->id;
                $address = Address::create($addressData);
            }
            $order = Order::create([
               'address_id' => $address->id,
               'user_id' => auth()->user()->id
            ]);
        } else {
            // crear el address
            $this->validate(request(), [
                'newAddress.email' => 'required|email',
                'newAddress.name' => 'required',
                'newAddress.street' => 'required',
                'newAddress.city' => 'required',
                'newAddress.zip' => 'required',
                'newAddress.country' => 'required',
                'newAddress.phone_number' => 'required',
            ]);
            $addressData = request()->except(['newAddress.is_valid', 'newAddress.show_errors'])['newAddress'];
            $address = Address::create($addressData);
            $order = Order::create([
               'address_id' => $address->id,
               'email' => $address->email
            ]);
            session(['email' => $order->email]);
        }

        // Se cumple para ambos casos, tanto usuario como guest
        foreach(request()->items as $itemData){
            if($itemData['quantity'] > 0) {
                $item = new Item;
                $item->order_id = $order->id;
                $item->product_id = $itemData['product']['id'];
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
        return $order->total;
    }
}
