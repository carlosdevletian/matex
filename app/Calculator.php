<?php

namespace App;

class Calculator
{
    public function unitPrice($productId, $designId, $quantity)
    {
        // $product = Product::findOrFail($productId);
        // $design = Design::findOrFail($designId);
        return 7;   
    }

    public function totalPrice($quantity, $unitPrice)
    {
        return $quantity * $unitPrice; 
    }
}
