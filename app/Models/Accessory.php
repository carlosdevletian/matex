<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function imagePath()
    {
        return asset('accessories/'.$this->image_name);
    }
}
