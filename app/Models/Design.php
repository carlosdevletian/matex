<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'image_name', 'price'
    ];
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
