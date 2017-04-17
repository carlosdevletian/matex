<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Order $order)
    {
        return $order->user_id == $user->id || $user->hasRole('admin');
    }
}
