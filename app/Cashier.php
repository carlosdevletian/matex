<?php

namespace App;

use Validator;
use App\Models\Item;
use App\Models\Order;
use App\Models\Design;
use App\Models\Address;

class Cashier
{
    protected $identifier;

    protected $identifier_value;

    protected $design;

    protected $address;

    protected $order;

    public function checkout()
    {
        $this->determineClient()
            ->determineAddress()
            ->createOrder()
            ->addItems()
            ->determineAmount();

        return $this->order->total;
    }

    protected function determineClient()
    {
        if(auth()->check()) {
            $this->identifier = 'user_id';
            $this->identifier_value = auth()->user()->id;
        }else {
            $this->identifier = 'email';
            $this->identifier_value = request()->newAddress['email'];
            session(['email' => $this->identifier_value]);
            $this->createGuestDesign();
        }

        session()->forget(['design']);

        return $this;
    }

    protected function createGuestDesign()
    {
        $this->design = Design::create([$this->identifier => $this->identifier_value, 'image_name' => session('design')]);
        $this->design->move();
    }

    protected function determineAddress()
    {
        if(request()->selectedAddress != 0){
            $this->address = Address::findOrFail(request()->selectedAddress);
        }else {
            Validator::make(request()->all(), [
                'newAddress.email' => 'required|email',
                'newAddress.name' => 'required',
                'newAddress.street' => 'required',
                'newAddress.city' => 'required',
                'newAddress.zip' => 'required',
                'newAddress.country' => 'required',
                'newAddress.phone_number' => 'required',
            ])->validate();
            $addressData = request()->except(['newAddress.is_valid', 'newAddress.show_errors'])['newAddress'];
            $addressData[$this->identifier] = $this->identifier_value;
            $this->address = Address::create($addressData);
        }

        return $this;
    }

    protected function createOrder()
    {
        $this->order = Order::create([
            'address_id' => $this->address->id,
            $this->identifier => $this->identifier_value
        ]);

        return $this;
    }

    protected function addItems()
    {
        foreach(request()->items as $itemData){
            if(!empty($itemData['cart_id'])){
                $item = Item::findOrFail($itemData['id']);
                $item->order_id = $this->order->id;
                $item->cart_id = null;
            }else{
                $item = new Item;
                $item->order_id = $this->order->id;
                $item->product_id = $itemData['product']['id'];
                if(auth()->check()) {
                    $item->design_id = $itemData['design_id'];
                }else {
                    $item->design_id = $this->design->id;
                }
                $item->quantity = $itemData['quantity'];
            }

            $item->calculatePricing();
            $item->save();
        }

        return $this;
    }

    protected function determineAmount()
    {
        $this->order->assignReferenceNumber();
        $this->order->calculatePricing();
        $this->order->save();
    }
}
