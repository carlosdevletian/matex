@extends('layouts.app')

@section('title')
    Order # {{ $order->reference_number }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($order->status->name == 'Payment Pending')
                    <div class="mg-top-10 alert alert-danger">
                        <h5>Your payment could not be processed, please try again</h5>
                    </div>
                @endif
                <h3 class="mg-btm-20 text-center">Order details</h3>
                @if(admin())
                    @include('admins.edit-order')
                @endif
                <div class="Card">
                    <div class="row text-center mg-top-10">
                        <div class="col-sm-4">
                            <p style="color: {{ $order->status->color }}; border: 2px solid {{ $order->status->color }}; border-radius: 3px"    data-toggle="tooltip"
                                data-placement="bottom"
                                title="{{ $order->status->name . " since " . $order->status->updated_at->diffForHumans() }}">
                                    {{ $order->status->name }}
                            </p>
                            @unless(admin())
                                @if($order->status->name == 'Payment Pending')
                                    <order-pay :order="{{ $order }}"></order-pay>
                                @endif
                            @endunless
                        </div>
                        <div class="col-sm-4">
                            <p>Placed on {{ $order->formated_date }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p>Order #{{ $order->reference_number }}</p>
                        </div>
                    </div>
                </div>
                <order-show :order="{{ $order }}" 
                            :items="{{ $order->items }}" 
                            :address="{{ $order->address }}">
                </order-show>
                @unless(auth()->check())
                    <p class="text-center"><a href="{{ route('register.client', ['token' => $token]) }}" class="Button--secondary">Create an Account</a></p>
                @endunless
            </div>
        </div>
    </div>
@endsection

@push('head_scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
