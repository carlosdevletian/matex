<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        $cart = auth()->user()->cart;
        $addresses = auth()->user()->addresses;
        $items = $cart->availableItems()->values();
        $unavailableItems = $cart->unavailableItems()->values();
        return view('carts.show', compact('cart', 'addresses', 'items', 'unavailableItems'));
    }
}
