<?php

namespace App\Http\Controllers;

use App\Calculator;
use App\Models\Item;
use Illuminate\Http\Request;

class VueController extends Controller
{
    public function addToCart()
    {
        $items = collect(request()->toArray());
        $cartId = auth()->user()->cart->id;
        $items->map(function($item) use($cartId){
            $item['cart_id'] = $cartId;
            return Item::create($item);
        });
    }

    public function calculatePrice()
    {
        $calculator = new Calculator();
        $unitPrice = $calculator->unitPrice(request()->product_id, request()->design_id, request()->quantity);
        $totalPrice = $calculator->totalPrice(request()->quantity, $unitPrice);
        return response()->json(['unit_price' => $unitPrice, 'total_price' => $totalPrice], 200);
    }
}
