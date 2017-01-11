<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
