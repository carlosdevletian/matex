<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Facades\App\Tax;
use App\Models\Order;
use App\ItemCalculator;
use Facades\App\Cashier;
use App\Events\OrderPlaced;
use Illuminate\Http\Request;
use App\Models\RegisterToken;
use App\Billing\PaymentGateway;
use App\Events\OrderPaymentFailed;
use App\Billing\InvalidTokenException;
use App\Billing\PaymentFailedException;

class VueController extends Controller
{
    private $paymentGateway;

    function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function addToCart(Request $request)
    {
        collect($request->toArray())->map(function ($item) {
            $item = new Item($item);
            $item->cart_id = auth()->user()->cart->id;

            if($existingItem = Item::alreadyExists($item)) {
                $existingItem->quantity += $item->quantity;
                $existingItem->calculate()->save();
                return;
            }
            $item->calculate()->save();
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

    public function calculatePrice(Request $request)
    {
        $item = new Item($request->item);
        
        return response()->json([
            'item' => $item->calculate()->load('product'),
        ], 200);
    }

    public function calculateTax()
    {
        return response()->json([
            'tax_percentage' => Tax::calculate(request()->state)
        ], 200);
    }

    public function cartPreview()
    {
        $cart = auth()->user()->cart;
        return response()->json([
            'itemQuantity' => $cart->availableItems()->count(),
            'firstItem' => $cart->availableItems()->first(),
            'subtotal' => $cart->orderTotal(),
        ], 200);
    }

    public function pay()
    {
        $this->validate(request(), [
            'payment_token' => 'required',
        ]);

        $order = Cashier::checkout();

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
            $charge = $this->paymentGateway->charge($order->total, request('payment_token'));
            event(new OrderPlaced($order, $charge));

            return response()->json([
                'status' => $order->status->name,
                'order_url' => $order->showUrl()
            ], 200);
        } catch (PaymentFailedException $e) {
            event(new OrderPaymentFailed($order, $e->charge));
            
            return response()->json([
                'status' => $order->status->name,
                'order_url' => $order->showUrl()
            ], 422);
        } catch (InvalidTokenException $e) {
            return response()->json([], 422);
        }
    }
}
