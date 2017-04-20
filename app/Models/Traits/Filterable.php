<?php

namespace App\Models\Traits;

trait Filterable
{
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}