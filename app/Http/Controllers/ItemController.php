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

    public function update(Item $item = null, Request $request)
    {
        if($item->exists) {
            $item = $this->updateExisting($item, $request);
        } else {
            $item = (new Item($request->item))->calculate()->load(['product', 'accessory']);
        }
        
        return response()->json([
            'item' => $item,
        ], 200);
    }

    public function destroy(Item $item)
    {
        $item->delete();
    }

    private function updateExisting(Item $item, Request $request)
    {
        if(! $request->item['quantity'] > 0) {
            return json(['error' => 'Could not process', 422]);
        }
        $item->quantity = $request->item['quantity'];
        $item->calculate()->save();
        return $item;
    }
}
