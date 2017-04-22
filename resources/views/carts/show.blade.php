@extends('layouts.app')

@section('title')
    Your shopping cart
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($items->count() > 0)
                    <h2 class="mg-btm-20 text-center">Shopping cart</h2>
                    <order-cart-create 
                        :addresses="{{ $addresses }}" 
                        :original-items="{{ $items }}" 
                        :original-unavailable-items="{{ $unavailableItems }}">
                    </order-cart-create>
                @else
                    <div>There are no items in your cart.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('head_scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
