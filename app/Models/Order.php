<?php

namespace App\Models;

use Facades\App\Tax;
use App\Models\Traits\Filterable;
use Facades\App\OrderReferenceNumber;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presenters\OrderPresenter;

class Order extends Model
{
    use Filterable;
    
    protected $fillable = [
        'user_id', 
        'address_id', 
        'email', 
        'status_id', 
        'responsible_id',
        'shipping_company',
        'tracking_number', 
        'tracking_url', 
        'reference_number',
        'card_last_four'
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $with = ['status'];

    public static function forItems($items, $address)
    {
        $order = self::create([
            'reference_number' => OrderReferenceNumber::generate(),
            'email' => $address->user_id ? null : $address->email,
            'user_id' => $address->user_id ?: null,
            'address_id' => $address->id,
        ]);

        $order->addItems($items);
        $order->calculatePricing();
        $order->setStatus('Payment Pending');

        return $order;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function availableItems()
    {
        return $this->items()->where('available', 1);
    }

    public function unavailableItems()
    {
        return $this->items()->where('available', 0);
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

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function setStatus($status)
    {
        $this->status_id = Status::findByName($status)->id;

        $this->save();
    }

    public function calculatePricing()
    {
        $this->subtotal()
            ->tax()
            ->total()
            ->update();
    }

    public function subtotal()
    {
        $this->subtotal = $this->availableItems()->sum('total_price');

        return $this;
    }

    public function tax()
    {
        $percentage = Tax::calculate($this->address->state);
        $this->tax = intval($this->subtotal * $percentage);

        return $this;
    }

    public function total()
    {
        $this->total = $this->subtotal + $this->tax;

        return $this;
    }

    public function addItems($items)
    {
        $items->each(function($item) {
            $item->cart_id = null;
        });
        $this->items()->saveMany($items);
    }

    public function belongsToUser()
    {
        return (! empty($this->user_id));
    }

    public function getFormatedDateAttribute()
    {
        return $this->created_at->format('F j, Y');
    }

    public static function show($referenceNumber)
    {
        return self::with(['items.design' => function($query){
                $query->withTrashed()->addSelect(['id', 'image_name', 'created_at']);
            }, 'status'])
            ->where('reference_number', $referenceNumber)->firstOrFail();
    }

    public static function activeForUser($userId = null, $take = 5)
    {
        return self::with('status')
            ->where('user_id', $userId ?: auth()->id())
            ->whereIn('status_id', Status::active())
            ->take($take)
            ->get();
    }

    public function itemsGroupedByDesign()
    {
        return $this->availableItems()->get()->groupBy(function($item) {
            return $item->design->image_name;
        });
    }

    public function scopeUnpaid($query)
    {
        return $query->whereIn('status_id', Status::unpaid());
    }

    public function cancel()
    {
        $canceledStatus = Status::canceled()[0];
        $this->update(['status_id' => $canceledStatus]);
    }

    public function isCanceled()
    {
        $canceledStatus = Status::canceled()[0];
        return $this->status_id == $canceledStatus;
    }

    public function present()
    {
        return new OrderPresenter($this);
    }

    public function showUrl()
    {
        if($this->belongsToUser()) {
            return route('orders.show', ['order' => $this->reference_number ]);
        }
        $token = RegisterToken::whereEmail($this->email)->first();
        return route('orders.show', ['order' => $this->reference_number, 'token' => $token->token]);
    }
}
