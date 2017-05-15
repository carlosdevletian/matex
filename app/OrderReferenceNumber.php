<?php 

namespace App;

use Carbon\Carbon;
use App\Models\Order;

class OrderReferenceNumber
{
    public function generate()
    {
        $date = Carbon::now();
        $currentMonth = (string) $date->format('m');
        $ordersInCurrentMonth = Order::whereMonth('created_at', $currentMonth)->count();

        return vsprintf('%s-%s', [
            $date->format('Ymd'),
            $ordersInCurrentMonth + 1
        ]);
    }
}