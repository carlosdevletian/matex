<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const STATES = [
        'paid' => [2,3,4,5],
        'unpaid' => [1],
        'active' => [1,2,3,4],
        'canceled' => [6]
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function findByName($status)
    {
        return self::whereName($status)->first();
    }

    public static function __callStatic($method, $parameters)
    {

        if (array_key_exists($method, self::STATES)) {
            return self::STATES[$method];
        }

        return parent::__callStatic($method, $parameters);
    }
}
