<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'order_id',
        'design_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }
}
