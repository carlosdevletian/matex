@extends('layouts.app', ['backgroundColor' => 'blue-background'])

@section('title')
    Order # {{ $order->reference_number }}
@endsection

@section('content')
    <div class="pd-top-50">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="mg-btm-20 text-center">Order # {{ $order->reference_number }}</h2>
                    <order-show :order="{{ $order }}" :items="{{ $order->items }}" :address="{{ $order->address }}"></order-show>
                </div>
            </div>
        </div>
    </div>
@endsection
