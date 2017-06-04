<?php

namespace App\Models\Traits;

use App\Models\Item;

trait hasItems
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function unpaidItems()
    {
        return $this->items()
                    ->where(function ($q) {
                        $q->whereNull('order_id')
                            ->orWhereHas('order.status', function ($q) {
                                // Status de 'Payment Pending'
                                $q->whereIn('id', [1]);
                            });
                    });
    } 

    public function enable()
    {
        $this->update(['is_active' => true]);
        $this->unpaidItems->each->enable();
    }

    public function disable()
    {
        $this->update(['is_active' => false]);
        $this->unpaidItems->each->disable();
    }
}