<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {
        $designs = auth()->user()->recentDesigns();
        $orders = auth()->user()->activeOrders();
        $addresses = auth()->user()->addresses->count();

        return view('dashboard', compact('designs', 'orders', 'addresses'));
    }
}
