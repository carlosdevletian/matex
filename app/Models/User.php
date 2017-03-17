<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Address;
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
        'name', 'email', 'password', 'role_id'
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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function hasOrder($order)
    {
        return $this->id == $order->user_id;
    }

    public function hasAnyDesigns()
    {
        return $this->designs->count() > 0;
    }

    public function recentDesigns()
    {
        return $this->designs->sortByDesc('created_at')->take(2);
    }

    public function activeOrders()
    {
        return $this->orders->whereIn('status.id', [1,2,3,4]);
    }
}
