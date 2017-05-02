<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['display_position', 'category_id', 'name', 'width', 'length', 'is_active'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function activeFrom($categoryId)
    {
       return static::where('category_id', $categoryId)
                ->where('is_active', true)
                ->get();
    }

    public function enable()
    {
        $this->update(['is_active' => true]);
        $this->unpaidItems->each->enable();
    }

    public function disable()
    {
        $this->update(['is_active' => false]);
        $this->unpaidItems->each->disable();
    }

    public function setActive(bool $active)
    {
        $active ? $this->enable() : $this->disable();
    }

    public function updateFromRequest($data, $displayPosition)
    {
        $this->update([
            'name' => strtolower($data[1]),
            'width' => $data[2],
            'length' => $data[3],
            'display_position' => $displayPosition
        ]);
        $this->setActive($data[4]);
        return $this;
    }

    public static function newProduct($data, $categoryId, $displayPosition)
    {
        // validar información del producto nuevo?
        if(!$data[1] || !$data[2] || !$data[3]) {
            return;
        }
        $product = self::create([
            'name' => strtolower($data[1]),
            'width' => $data[2],
            'length' => $data[3],
            'category_id' => $categoryId,
            'display_position' => $displayPosition
        ]);
        $product->setActive($data[4]);
        return $product;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    public function unpaidItems()
    {
        return $this->items()
                    ->where(function ($q) {
                        $q->whereNull('order_id')
                            ->orWhereHas('order.status', function ($q) {
                                // Status de 'Payment Pending'
                                $q->where('id', 1);
                            });
                    });
    }
}
