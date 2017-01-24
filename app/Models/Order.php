<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['address_id'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
