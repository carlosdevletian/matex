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
}
