<?php

namespace App\Models;

use App\Calculator;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'order_id',
        'cart_id',
        'design_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function calculatePricing()
    {
        $calculator = new Calculator();
        $this->unit_price = $calculator->unitPrice($this->product_id, $this->design_id, $this->quantity);
        $this->total_price = $calculator->totalPrice($this->quantity, $this->unit_price);
        $this->save();
    }

    public static function exists($data)
    {
        return self::where('cart_id', $data['cart_id'])
            ->where('design_id', $data['design_id'])
            ->where('product_id', $data['product_id'])
            ->first();
    }

    public static function inCart()
    {
        return self::detailed()->where('cart_id', auth()->user()->cart->id)
            ->leftJoin('designs', 'designs.id', '=', 'items.design_id')
            ->select('items.*', 'designs.image_name as image_name')
            ->get();
    }

    public static function detailed()
    {
        return self::with(['design' => function($query){
                $query->addSelect(['id', 'image_name', 'created_at']);
            }, 'product' => function($query) {
                $query->addSelect(['id', 'name', 'category_id']);
            }, 'product.category' => function($query){
                $query->addSelect(['id', 'name']);
            }]);
    }

    public function assignProduct($product)
    {
        if(is_int($product)) {
            return $this->product_id = $product;
        }
        return $this->product_id = $product->id;       
    }
}
