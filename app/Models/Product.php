<?php

namespace App\Models;

use App\Models\Traits\HasItems;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasItems;

    protected $fillable = ['display_position', 'category_id', 'name', 'width', 'length', 'is_active'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower( str_singular($value) );
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
}
