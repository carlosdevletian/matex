<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function imagePath()
    {
        return asset('accessories/'.$this->image_name);
    }

    public function enable()
    {
        $this->update(['is_active' => true]);
    }

    public function disable()
    {
        $this->update(['is_active' => false]);
    }

    public function isActive()
    {
        return (bool) $this->is_active;
    }
}
