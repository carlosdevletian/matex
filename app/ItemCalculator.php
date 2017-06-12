<?php

namespace App;

use App\Models\Item;

class ItemCalculator
{
    public $item;

    private $calculatedPrice = 0;

    function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function calculate()
    {
        $this->basePrice()
            ->accessoryPrice()
            ->set();

        return $this->item;
    }

    public function basePrice()
    {
        $this->calculatedPrice +=
            $this->item
            ->pricings()
            ->where('min_quantity', '<=', $this->item->quantity)
            ->where('max_quantity', '>=', $this->item->quantity)
            ->first()->unit_price;

        return $this;    
    }

    public function accessoryPrice()
    {
        if($accessory = $this->item->accessory) {
            $this->calculatedPrice += $accessory->price;
        }

        return $this;
    }

    public function set()
    {
        $this->item->unit_price = $this->calculatedPrice;

        $this->item->total_price = $this->item->quantity * $this->item->unit_price; 

        return $this;  
    }

    public function getCalculatedPrice()
    {
        return $this->calculatedPrice;
    }
}
