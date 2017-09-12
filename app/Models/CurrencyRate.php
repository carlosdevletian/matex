<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    protected $guarded = [];

    public function setCurrencyCodeAttribute($value)
    {
        $this->attributes['currency_code'] = strtoupper($value);
    }
}
