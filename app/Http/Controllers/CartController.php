<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        $cart = auth()->user()->cart;

        return view('carts.show', [
                    'cart' => $cart, 
                    'addresses' => auth()->user()->addresses, 
                    'items' => $cart->availableItems()->values(), 
                    'unavailableItems' => $cart->unavailableItems()->values(),
                    'categoryPricings' => $cart->categories()->mapWithKeys(function($category) {
                                    return [$category->name => $category->pricings];
                                })
                ]);
    }
}
