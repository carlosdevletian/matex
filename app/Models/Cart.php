<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);   
    }

    public function orderTotal()
    {
        return $this->items->sum(function ($item) {
            if($item->product->is_active) {
                return $item->total_price;
            }
        });
    }

    public function availableItems()
    {
         return $this->items->where('available', true);
    }

    public function unavailableItems()
    {
         return $this->items->where('available', false);
    }
}
