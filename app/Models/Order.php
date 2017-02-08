<?php

namespace App\Models;

use App\Calculator;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'address_id', 'email'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function assignReferenceNumber()
    {
        return $this->reference_number = uniqid();
    }

    public function calculatePricing()
    {
        $this->subtotal()
            ->shipping()
            ->tax()
            ->total();
    }

    public function subtotal()
    {
        $this->subtotal = $this->items()->sum('total_price');

        return $this;
    }

    public function shipping()
    {
        $calculator = new Calculator;
        $this->shipping = $calculator->shipping($this->address->zip);

        return $this;
    }

    public function tax()
    {
        $calculator = new Calculator;
        $percentage = $calculator->tax($this->address->zip);
        $this->tax = ($this->subtotal + $this->shipping) * $percentage;
        
        return $this;
    }

    public function total()
    {
        $this->total = $this->subtotal + $this->shipping + $this->tax;
    }
}
