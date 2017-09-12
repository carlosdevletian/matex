<?php

namespace App;

use App\Models\Item;
use App\Models\CurrencyRate;

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
            ->toPesos()
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

    public function toPesos()
    {
        $rate = CurrencyRate::where('currency_code', 'COP')->firstOrFail();

        $this->calculatedPrice *= $rate->to_dollar;

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

        return $this->item
            ->pricings()
            ->where('min_quantity', '<=', $this->item->quantity)
            ->sortBy('min_quantity')
            ->last()
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
