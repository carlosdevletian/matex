@extends('layouts.app')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>My Orders</h4>
                    </div>
                    <ul>
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <li>
                                    <h5><a href="{{ route('orders.show', ['order' => $order->reference_number]) }}">Order #{{ $order->reference_number }}</a></h5>
                                </li>
                            @endforeach
                        @else
                            <h5>No Orders Placed</h5>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
