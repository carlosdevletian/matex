<?php

namespace App;

use App\Models\Item;

class ItemCalculator
{
    public $item;

    function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function calculate()
    {
        $this->setUnitPrice()
            ->setTotalPrice();

        return $this->item;
    }

    public function setUnitPrice()
    {
        $this->item->unit_price = 700;

        return $this;  
    }

    public function setTotalPrice()
    {
        $this->item->total_price = $this->item->quantity * $this->item->unit_price; 

        return $this;
    }
}
