<?php

namespace App\Models\Traits;

use App\Models\Item;
use App\Models\Status;

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
                                $q->whereIn('id', Status::unpaid());
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