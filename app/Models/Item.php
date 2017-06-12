<?php

namespace App\Models;

use App\Calculator;
use App\ItemCalculator;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presenters\ItemPresenter;

class Item extends Model
{
    protected $fillable = [
        'order_id',
        'cart_id',
        'design_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'available',
        'accessory_id'
    ];

    protected $with = ['design', 'product.category', 'accessory'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function pricings()
    {
        return $this->product->category->pricings;
    }

    public function calculate()
    {
        return (new ItemCalculator($this))->calculate();
    }

    public static function alreadyExists(Item $item)
    {
        return self::where('cart_id', $item->cart_id)
            ->where('design_id', $item->design_id)
            ->where('product_id', $item->product_id)
            ->where('accessory_id', $item->accessory_id)
            ->first();
    }

    public static function inCart()
    {
        return self::where('cart_id', auth()->user()->cart->id)
            ->leftJoin('designs', 'designs.id', '=', 'items.design_id')
            ->select('items.*', 'designs.image_name as image_name')
            ->get();
    }

    public function assignProduct($product)
    {
        if(is_int($product)) {
            return $this->product_id = $product;
        }
        return $this->product_id = $product->id;       
    }

    public function enable()
    {
        $this->update(['available' => true]);
        if($this->order_id != null) $this->order->calculatePricing();
    }

    public function disable()
    {
        $this->update(['available' => false]);
        if($this->order_id != null) $this->order->updateOrCancel();
    }

    public function present()
    {
        return new ItemPresenter($this);
    }

    public static function generate($data, $design = null)
    {
        return self::hydrate($data)
                    ->map(function ($item) use ($design) {
                        return $item->withoutRelated()->persistOrDelete($design);
                    })->filter(function ($item) {
                        return $item instanceof self;
                    });
    }

    private function withoutRelated()
    {
        // Takes the Item instance and strips out the previously eager 
        // loaded relationships so it can be saved to the database.
        $filtered = collect($this->toArray())->except(['product', 'design', 'accessory'])->all();
        return $this->newFromBuilder($filtered);
    }

    private function persistOrDelete($design)
    {
        if($this->quantity < $this->minimumQuantity()) return $this->delete();

        // If the item has an id, its "exist" property must be set to 
        // true. That way the save() method will update that item,
        // otherwise it's going to generate a brand new record.
        $this->exists = isset($this->id);

        // Finally, assign the design id that was passed through,
        // if any, calculate the item's price, and persist it.
        if(isset($design)) $this->design_id = $design->id;
        $this->calculate()->save();
        return $this;
    }

    public function minimumQuantity()
    {
        return $this->pricings()
            ->sortBy('min_quantity')
            ->first()
            ->min_quantity;
    }
}
