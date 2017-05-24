<?php

namespace App;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Design;
use App\Models\Status;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Cashier
{
    use ValidatesRequests;

    protected $request, $client, $address, $design, $items, $order;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function checkout()
    {
        return $this->setClient()
                    ->setAddress()
                    ->createDesign()
                    ->addItems()
                    ->createOrder();
    }

    protected function setClient()
    {
        $isRegistered = auth()->check();

        $this->client = [
            'is_registered' => $isRegistered,
            'identifier' => $isRegistered ? 'user_id' : 'email',
            'user_id' => auth()->id(),
            'email' => $isRegistered ? null : $this->request->newAddress['email']
        ];

        return $this;
    }

    protected function setAddress()
    {
        if($this->request->selectedAddress != 0) {
            $this->address = Address::findOrFail($this->request->selectedAddress);
        } else {
            $this->address = $this->createNewAddress();
        }

        return $this;
    }

    protected function createDesign()
    {
        if($this->client['is_registered']){
            session()->forget(['design']); 
            return $this;
        }
        
        if(! empty(json_decode($this->request->design)) && json_decode($this->request->design)->is_predesigned) {
            $this->design = Design::findOrFail(json_decode($this->request->design)->id);
        }else{
            $this->design = Design::create([
                'email' => $this->client['email'], 
                'category_id' => $this->request->category_id,
                'image_name' => session('design'), 
                'views' => session('fpd-views'), 
                'comment' => session('design_comment')
            ]);
            $this->design->move();
            session()->forget(['fpd-views', 'design_comment', 'design']);
        }

        return $this;
    }

    protected function addItems()
    {
        $this->items = Item::generate($this->request['items'], $this->design);
        
        return $this;
    }

    protected function createOrder()
    {
        return Order::forItems($this->items, $this->address);
    }

    private function createNewAddress()
    {
        $this->validateNewAddress();
        
        $addressData = $this->request->except(['newAddress.is_valid', 'newAddress.show_errors'])['newAddress'];
        $addressData[$this->client['identifier']] = $this->client[$this->client['identifier']];

        return Address::create($addressData);
    }

    private function validateNewAddress()
    {
        if(! $this->client['is_registered'] && User::whereEmail($this->client['email'])->first()){
            abort(422, "That email address belongs to a registered user");
        }

        $this->validate($this->request, [
            'newAddress.email' => 'sometimes|required|email|unique:users,email',
            'newAddress.name' => 'required',
            'newAddress.street' => 'required',
            'newAddress.city' => 'required',
            'newAddress.state' => 'required',
            'newAddress.zip' => 'required|zip',
            'newAddress.country' => 'required',
            'newAddress.phone_number' => 'required',
            'newAddress.comment' => 'nullable'
        ]);
    }
}
