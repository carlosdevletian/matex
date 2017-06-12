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
        $this->productPrice()
            ->accessoryPrice()
            ->set();

        return $this->item;
    }

    public function productPrice()
    {
        $this->calculatedPrice += $this->getPricing();

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

    private function getPricing()
    {
        $this->validateQuantity();

        if($this->item->quantity >= $this->item->maxQuantityPricing()->max_quantity) {
            return $this->item->maxQuantityPricing()->unit_price;
        }

        return $this->item
            ->pricings()
            ->where('min_quantity', '<=', $this->item->quantity)
            ->where('max_quantity', '>=', $this->item->quantity)
            ->first()
            ->unit_price;
    }

    private function validateQuantity()
    {
        if($this->item->quantity < $minQuantity = $this->item->minQuantityPricing()->min_quantity) {
            $this->item->quantity = $minQuantity;
        }
    }

    public function getCalculatedPrice()
    {
        return $this->calculatedPrice;
    }
}
