@extends('layouts.email')

@section('greeting')
    Order # {{ $order->reference_number }} was placed
@endsection

@section('intro')
    Your order was placed, its status is {{ $order->status->name }}
    <br>
    Order Summary:
    <br>
    @isset($shipping['shipping_company'])
        <h1>Shipping Details</h1>
        <h3>Shipping company: {{ $shipping['shipping_company'] }}</h3>
        <h3>Tracking Number: {{ $shipping['tracking_number'] }}</h3>
        <h3>Tracking Url: {{ $shipping['tracking_url'] }}</h3>
    @endisset
    <ul>
        <li>Subtotal {{ $order->subtotal }}</li>
        <li>Shipping {{ $order->shipping }}</li>
        <li>Tax {{ $order->tax }}</li>
        <li>Total {{ $order->total }}</li>
    </ul>
    @if($order->status->name == 'Payment Pending')
        <h4>Your payment could not be processed</h4>
        <a href="{{ route('orders.show', ['order' => $order->reference_number]) }}">Retry Payment</a>
    @else
        <a href="{{ route('orders.show', ['order' => $order->reference_number]) }}">View Details</a>
    @endif
    @if(! empty($comment))
        <h5>{{ $comment }}</h5>
    @endif
    @if(! empty($token))
        <a href="{{ route('register.client', ['token' => $token]) }}">Register</a>
    @endif
@endsection

@section('outro')
    For more information send us an email
@endsection
