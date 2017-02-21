<?php

namespace App\Http\Controllers;

use App\Calculator;
use App\Models\Item;
use App\Models\Order;
use App\Models\Design;
use App\Models\Address;
use Illuminate\Http\Request;

class VueController extends Controller
{
    public function addToCart()
    {
        $items = collect(request()->toArray());
        $items->map(function($item) {
            $item['cart_id'] = auth()->user()->cart->id;
            $item['product_id'] = $item['product']['id'];
            $item['design_id'] = $item['design_id'];

            if($originalItem = Item::exists($item)) {
                $originalItem->quantity += $item['quantity'];
                $originalItem->save();
                return;
            }
            $newItem = Item::create($item);
            $newItem->calculatePricing();
        });
        session()->forget(['design', 'category_id']);
    }

    public function calculatePrice()
    {
        $calculator = new Calculator();
        $unitPrice = $calculator->unitPrice(request()->product['id'], 1, request()->quantity);
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
        //determinar si es user o guest
        //crear address
        //crear diseño para guest
        //crear orden
        //crear items
        //calcular precio orden

        if(auth()->check()) {
            $identifier = 'user_id';
            $identifier_value = auth()->user()->id;
        }else {
            $identifier = 'email';
            $identifier_value = request()->newAddress['email'];
            session(['email' => $identifier_value]);
            $design = Design::create([$identifier => $identifier_value, 'image_name' => session('design')]);
        }

        session()->forget(['design']);

        if(request()->selectedAddress != 0){
            $address = Address::findOrFail(request()->selectedAddress);
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
            $addressData[$identifier] = $identifier_value;
            $address = Address::create($addressData);
        }

        $order = Order::create([
            'address_id' => $address->id,
            $identifier => $identifier_value
        ]);

        foreach(request()->items as $itemData){
            if(!empty($itemData['cart_id'])){
                $item = Item::findOrFail($itemData['id']);
                $item->order_id = $order->id;
                $item->cart_id = null;
            }else{
                $item = new Item;
                $item->order_id = $order->id;
                $item->product_id = $itemData['product']['id'];
                if(auth()->check()) {
                    $item->design_id = $itemData['design_id'];
                }else {
                    $item->design_id = $design->id;
                }
                $item->quantity = $itemData['quantity'];
            }

            $item->calculatePricing();
            $item->save();
        }

        if(!auth()->check()){
            $item->design->move();
        }

        $order->assignReferenceNumber();
        $order->calculatePricing();
        $order->save();
        return $order->total;
    }
}
