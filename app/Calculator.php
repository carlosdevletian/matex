<?php

namespace App;

class Calculator
{
    public function unitPrice($productId, $designId, $quantity)
    {
        // $product = Product::findOrFail($productId);
        // $design = Design::findOrFail($designId);
        return 700;   
    }

    public function totalPrice($quantity, $unitPrice)
    {
        return $quantity * $unitPrice; 
    }

    public function shipping($zipCode)
    {
        return 1100;
    }

    public function tax($zipCode)
    {
        return 0.10;
    }
}
