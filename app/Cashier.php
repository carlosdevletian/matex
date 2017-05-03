<?php

namespace App;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Status;
use App\Models\Design;
use App\Models\Address;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Cashier
{
    use ValidatesRequests;

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

        return $this->order;
    }

    protected function determineClient()
    {
        if(auth()->check()) {
            $this->identifier = 'user_id';
            $this->identifier_value = auth()->user()->id;
        }else {
            if(User::whereEmail(request()->newAddress['email'])->first()) {
                abort(422, "That email address belongs to a registered user");
            }
            $this->identifier = 'email';
            $this->identifier_value = request()->newAddress['email'];
            $this->createGuestDesign();
            session()->forget(['fpd-views', 'design_comment']);
        }

        session()->forget(['design']);

        return $this;
    }

    protected function createGuestDesign()
    {
        $this->design = Design::create([
            $this->identifier => $this->identifier_value, 
            'image_name' => session('design'), 
            'views' => session('fpd-views'), 
            'category_id' => request()->category_id,
            'comment' => session('design_comment')
        ]);
        $this->design->move();
    }

    protected function determineAddress()
    {
        if(request()->selectedAddress != 0){
            $this->address = Address::findOrFail(request()->selectedAddress);
        }else {
            $this->validate(request(), [
                'newAddress.email' => 'sometimes|required|email|unique:users,email',
                'newAddress.name' => 'required',
                'newAddress.street' => 'required',
                'newAddress.city' => 'required',
                'newAddress.state' => 'required',
                'newAddress.zip' => 'required|digits:5',
                'newAddress.country' => 'required',
                'newAddress.phone_number' => 'required',
                'newAddress.comment' => 'nullable'
            ]);
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
            $this->identifier => $this->identifier_value,
        ]);

        $this->order->setStatus('Payment Pending');

        return $this;
    }

    protected function addItems()
    {
        $items = Item::generate(request('items'), $this->design);
        
        foreach ($items as $item) {
            $this->order->addItem($item);
        }
        
        return $this;
    }

    protected function determineAmount()
    {
        $this->order->assignReferenceNumber();
        $this->order->calculatePricing();
    }
}
