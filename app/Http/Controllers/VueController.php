<?php

namespace App\Http\Controllers;

use App\Cashier;
use App\Calculator;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Events\OrderPlaced;
use Illuminate\Http\Request;
use App\Models\RegisterToken;
use App\Billing\PaymentGateway;
use App\Billing\PaymentFailedException;

class VueController extends Controller
{
    private $paymentGateway;

    private $calculator;

    function __construct(PaymentGateway $paymentGateway, Calculator $calculator)
    {
        $this->paymentGateway = $paymentGateway;
        $this->calculator = $calculator;
    }

    public function addToCart()
    {
        $items = collect(request()->toArray());
        $items->map(function($item) {
            $item['cart_id'] = auth()->user()->cart->id;
            $item['product_id'] = $item['product']['id'];
            $item['design_id'] = $item['design_id'];

            if($originalItem = Item::exists($item)) {
                $originalItem->quantity += $item['quantity'];
                $originalItem->save();
                return;
            }
            $newItem = Item::create($item);
            $newItem->calculatePricing();
        });
        session()->forget(['design', 'category_id']);
    }

    public function validateEmail()
    {
        if($user = User::where('email', request('email'))->first()) {
            if($user->id == auth()->id()) {
                return response()->json([], 200);
            }
            return response()->json(['email' => 'Email address is not valid, please try another one.'], 422);
        }
        return response()->json([], 200);
    }

    public function calculatePrice()
    {
        $unitPrice = $this->calculator->unitPrice(request()->product['id'], 1, request()->quantity);
        $totalPrice = $this->calculator->totalPrice(request()->quantity, $unitPrice);
        return response()->json(['unit_price' => $unitPrice, 'total_price' => $totalPrice], 200);
    }

    public function calculateShipping()
    {
        $shipping = $this->calculator->shipping(request()->zip);
        return response()->json(['shipping' => $shipping], 200);
    }

    public function calculateTax()
    {
        $taxPercentage = $this->calculator->tax(request()->zip);
        return response()->json(['tax_percentage' => $taxPercentage], 200);
    }

    public function cartPreview()
    {
        return response()->json([
            'itemQuantity' => auth()->user()->cart->availableItems()->count(),
            'firstItem' => auth()->user()->cart->availableItems()->first(),
            'subtotal' => auth()->user()->cart->orderTotal()/100,
        ], 200);
    }

    public function pay()
    {
        $this->validate(request(), [
            'payment_token' => 'required',
        ]);

        $order = (new Cashier())->checkout();

        if($order->total != request('total_price')) {
            return response()->json([
                'error' => 'The amounts do not match',
                'order_reference_number' => $order->reference_number
            ], 422);
        }

        return $this->attemptPayment($order);
    }

    public function retryPayment()
    {
        $this->validate(request(), [
            'payment_token' => 'required',
        ]);
        
        $order = Order::findOrFail(request('order_id'));

        return $this->attemptPayment($order);
    }

    private function attemptPayment($order)
    {
        try {
            $this->paymentGateway->charge($order->total, request('payment_token'));
            $order->setStatus('Payment Approved');
            event(new OrderPlaced($order));
            return response()->json([
                'status' => $order->status->name,
                'order_reference_number' => $order->reference_number
            ], 200);
        } catch (PaymentFailedException $e) {
            event(new OrderPlaced($order));
            return response()->json([
                'status' => $order->status->name,
                'order_reference_number' => $order->reference_number
            ], 422);
        }
    }
}
