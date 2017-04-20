<?php

namespace App\Models;

use App\Calculator;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Filterable;
    
    protected $fillable = ['user_id', 'address_id', 'email', 'status_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setStatus($status)
    {
        $this->status_id = Status::findByName($status)->id;

        $this->save();
    }

    public function assignReferenceNumber()
    {
        return $this->reference_number = uniqid();
    }

    public function calculatePricing()
    {
        $this->subtotal()
            ->shipping()
            ->tax()
            ->total();
    }

    public function subtotal()
    {
        $this->subtotal = $this->items()->sum('total_price');

        return $this;
    }

    public function shipping()
    {
        $calculator = new Calculator;
        $this->shipping = $calculator->shipping($this->address->zip);

        return $this;
    }

    public function tax()
    {
        $calculator = new Calculator;
        $percentage = $calculator->tax($this->address->zip);
        $this->tax = intval(($this->subtotal + $this->shipping) * $percentage);

        return $this;
    }

    public function total()
    {
        $this->total = $this->subtotal + $this->shipping + $this->tax;

        return $this;
    }

    public function addItem(Item $item)
    {
        $item->cart_id = null;
        $this->items()->save($item);
    }

    public function belongsToUser()
    {
        return (! empty($this->user_id));
    }

    public function getFormatedDateAttribute()
    {
        return $this->created_at->format('F j, Y');
    }

    public static function activeForUser($userId)
    {
        return self::with('status')
            ->where('user_id', $userId)
            ->whereIn('status_id', [1,2,3,4])
            ->take(5)
            ->get();
    }
}
