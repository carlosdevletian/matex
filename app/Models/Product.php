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

        foreach ($this->items as $item) {
            $item->enable();
        }
    }

    public function disable()
    {
        $this->update(['is_active' => false]);

        foreach ($this->items as $item) {
            $item->disable();
        }
    }

    public function setActive(bool $active)
    {
        $active ? $this->enable() : $this->disable();
    }

    public function updateFromRequest($data, $displayPosition)
    {
        $this->update([
            'name' => $data[1],
            'width' => $data[2],
            'length' => $data[3],
            'display_position' => $displayPosition
        ]);
        $this->setActive($data[4]);
        return $this;
    }

    public static function new($data, $categoryId, $displayPosition)
    {
        // validar información del producto nuevo?
        if(!$data[1] || !$data[2] || !$data[3] || !$data[4] ) {
            return;
        }
        $product = self::create([
            'name' => $data[1],
            'width' => $data[2],
            'length' => $data[3],
            'category_id' => $categoryId,
            'display_position' => $displayPosition
        ]);
        $product->setActive($data[4]);
        return $product;
    }
}
