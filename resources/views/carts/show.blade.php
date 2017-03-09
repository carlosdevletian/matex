@extends('layouts.app', ['backgroundColor' => 'blue-background'])

@section('title')
    Your shopping cart
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($cart->items->count() > 0)
                    <h2 class="mg-btm-20">Shopping cart</h2>
                    <cart :addresses="{{ $addresses }}"></cart>
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
