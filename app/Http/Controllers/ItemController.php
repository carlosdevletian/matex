<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::where('cart_id', auth()->user()->cart->id)
            ->leftJoin('designs', 'designs.id', '=', 'items.design_id')
            ->select('items.*', 'designs.image_name as image_name')
            ->get();

        return $items;
    }

    public function update($item)
    {
        if(! request()->quantity > 0) {
            return json(['error' => 'Could not process', 422]);
        }
        $item = Item::findOrFail(request()->id);
        $item->quantity = request()->quantity;
        $item->calculatePricing();
        $item->save();
        return $item;   
    }

    public function destroy(Item $item)
    {
        $item->delete();
    }
}
