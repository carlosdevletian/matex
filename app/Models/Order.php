<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'address_id'];

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
        $this->shipping = 11;

        return $this;
    }

    public function tax()
    {
        $this->tax = ($this->subtotal + $this->shipping) * 0.12;

        return $this;
    }

    public function total()
    {
        $this->total = $this->subtotal + $this->shipping + $this->tax;
    }
}
