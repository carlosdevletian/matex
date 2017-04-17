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
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->total_price;
        }
        return $total;
    }

    public function availableItems()
    {
         return $this->items->where('available', true)->load('product.category','design');
    }

    public function unavailableItems()
    {
         return $this->items->where('available', false)->load('product.category','design');
    }
}
