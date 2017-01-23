<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        $cart = auth()->user()->cart;
        return view('carts.show', compact('cart'));
    }
}
