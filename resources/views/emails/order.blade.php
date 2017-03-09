@extends('layouts.email')

@section('greeting')
    Order # {{ $order->reference_number }} was placed
@endsection

@section('intro')
    Your order was placed, its status is {{ $order->status->name }}
    <br>
    Order Summary:
    <br>
    <ul>
        <li>Subtotal {{ $order->subtotal }}</li>
        <li>Shipping {{ $order->shipping }}</li>
        <li>Tax {{ $order->tax }}</li>
        <li>Total {{ $order->total }}</li>
    </ul>
@endsection

@section('outro')
    For more information send us an email
@endsection
