<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {
        if(auth()->user()->hasRole('admin')){
            return view('admin-dashboard');
        }

        $designs = auth()->user()->recentDesigns();
        $orders = auth()->user()->activeOrders();
        $addresses = auth()->user()->addresses->count();

        return view('dashboard', compact('designs', 'orders', 'addresses'));
    }

    public function searchClient()
    {
        $this->validate(request(), [
            'email' => 'required|email'
        ]);

        $user = User::where('email', request()->email)->first();

        if(! empty($user)){
            return redirect()->route('users.show', ['user' => $user->id]);
        }

        flash()->error('Error','No clients found with that email');
        return redirect()->back();
    }

    public function searchOrder()
    {
        $this->validate(request(), [
            'reference' => 'required'
        ]);

        $order = Order::where('reference_number', request()->reference)->first();

        if(! empty($order)){
            return redirect()->route('orders.show', ['order' => $order->reference_number]);
        }

        flash()->error('Error','No orders found with that reference number');
        return redirect()->back();
    }
}
