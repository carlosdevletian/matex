@extends('layouts.app')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h4>{{ $user->name }}</h4>
                <h6>{{ $user->email }}</h6>
                @foreach($user->orders as $order)
                    <p>Order: {{ $order->reference_number }}</p>
                    <p>Total: {{ $order->total }} $</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection
