<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return Item::inCart();
    }

    public function create(Request $request)
    {
        $item = new Item;
        $item->product_id = $request->product_id;
        $item->design_id = $request->design;
        $item->quantity = 0;
        $item->unit_price = 0;
        $item->total_price = 0;
        return $item->load('product');
    }

    public function update(Item $item, Request $request)
    {
        if(! $request->item['quantity'] > 0) {
            return json(['error' => 'Could not process', 422]);
        }
        $item->quantity = $request->item['quantity'];
        $item->calculate()->save();
        return response()->json([
            'item' => $item,
        ], 200);
    }

    public function destroy(Item $item)
    {
        $item->delete();
    }
}
