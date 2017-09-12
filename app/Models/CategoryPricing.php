<?php

namespace App\Models;

use App\ValidationFailure;
use Illuminate\Database\Eloquent\Model;

class CategoryPricing extends Model
{
    protected $guarded = [];

    public static function addToCategory($category, array $attributes = [])
    {
        return tap(self::newModelInstance($attributes), function ($pricing) use ($category) {
            self::validateUnitPrice($category->pricings, $pricing)->save();
        });
    }

    public static function validateUnitPrice($collection, $pricing = [])
    {
        $pricings = $pricing ? collect($collection)->push($pricing) : collect($collection);

        if($pricings->sortBy('min_quantity')->pluck('min_quantity') != ($pricings->sortByDesc('unit_price'))->pluck('min_quantity')) {
            ValidationFailure::fail("The pricing's quantity and unit price do not meet the required criteria", "unit_price");
        };
        return $pricing;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function toRate($rate)
    {
        return $this->unit_price * $rate->to_dollar;
    }
}
