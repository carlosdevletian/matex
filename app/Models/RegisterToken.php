<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token',
    ];

    /**
     * Get the route key for implicit model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    public static function generateFor($email)
    {
        return static::create([
            'email' => $email,
            'token'   => str_random(50),
        ])->token;
    }
}
