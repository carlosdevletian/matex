<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user()
    {
        return $this->hasMany(User::class);
    }

    public static function findByName($role)
    {
        return self::whereName($role)->first();
    }
}
