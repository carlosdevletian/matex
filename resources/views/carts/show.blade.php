@extends('layouts.app')

@section('title')
    Your shopping cart
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="mg-btm-20 text-center main-title">Shopping cart</h3>
                <order-cart-create 
                    :addresses="{{ $addresses }}" 
                    :original-items="{{ $items }}" 
                    :original-unavailable-items="{{ $unavailableItems }}">
                </order-cart-create>
            </div>
        </div>
    </div>
@endsection

@push('head_scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
