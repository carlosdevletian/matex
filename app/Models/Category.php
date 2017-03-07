<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug_name'] = str_slug($value);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
