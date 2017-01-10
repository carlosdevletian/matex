<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use App\Mail\ResetPassword as PasswordResetMail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new PasswordResetMail($token));
    }

    public function address()
    {
        return $this->hasMany(Adress::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasOrder($order)
    {
        return $this->id == $order->user_id;
    }
}
