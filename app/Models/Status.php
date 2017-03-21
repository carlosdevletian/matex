<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function findByName($status)
    {
        return self::whereName($status)->first();
    }
}