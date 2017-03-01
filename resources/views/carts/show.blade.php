@extends('layouts.app')

@section('title')
    Your shopping cart
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your shopping cart.
                </div>
                @if($cart->items->count() > 0)
                    <div class="panel-body">
                        <cart :addresses="{{ $addresses }}"></cart>
                    </div>
                @else
                    <div class="panel-body">
                        <div>There are no items in your cart.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
