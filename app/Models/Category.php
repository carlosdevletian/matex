<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'crop_width', 'crop_height', 'crop_x_position', 'crop_y_position', 'image_name'];

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
