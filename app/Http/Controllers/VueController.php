<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class VueController extends Controller
{
    public function addToCart()
    {
        foreach (request()->toArray() as $item) {
            $item['cart_id'] = auth()->user()->cart->id;
            $newItem = Item::create($item);
        }
    }

    public function calculatePrice()
    {
        switch (request()->product_id) {
        case 1:
            $price = request()->quantity * 10;
            return response()->json(['unit_price' => 10, 'total_price' => $price], 200);
            break;

        case 2:
        $price = request()->quantity * 20;
        return response()->json(['unit_price' => 20, 'total_price' => $price], 200);
        break;

        case 3:
            $price = request()->quantity * 30;
            return response()->json(['unit_price' => 30, 'total_price' => $price], 200);
            break;

        case 4:
        $price = request()->quantity * 40;
        return response()->json(['unit_price' => 40, 'total_price' => $price], 200);
        break;
        
        default:
            $price = request()->quantity * 50;
            return response()->json(['unit_price' => 50, 'total_price' => $price], 200);
            break;
        }
    }
}
