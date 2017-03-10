<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return Item::inCart();
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
