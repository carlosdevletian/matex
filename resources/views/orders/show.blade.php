@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    Order # {{ $order->reference_number }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($order->status->name == 'Payment Pending')
                    <div class="alert alert-danger">
                        <h4>Your payment could not be processed, please try again</h4>
                    </div>
                @endif
                <h2 class="mg-btm-20 text-center">Order details</h2>
                <div class="Card Card--half-pd">
                    <div class="table-responsive borderless">
                        <table class="table borderless mg-0">
                            <tbody>
                                <tr>
                                    <td class="col-xs-3">
                                        @if(admin())
                                            <h5>Edit Status</h5>
                                            <form method="POST" action="{{ route('orders.update', ['order' => $order->id]) }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="PUT">

                                                <div style="display: inline-block; width: 10px; height: 10px; border-radius: 100%; background-color: {{ $order->status->color }}"></div>

                                                <select name="status">
                                                    @foreach($statuses as $status)
                                                        @if($order->status->id == $status->id)
                                                            <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                                        @else
                                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                <div class="Input__icon">
                                                    <input id="comment"
                                                        type="text"
                                                        name="comment"
                                                        class="Form"
                                                        placeholder="Comment"
                                                        value="{{ old('comment') }}">
                                                </div>

                                                <button class="btn btn-default">Update</button>
                                            </form>
                                        @else
                                            <div style="display: inline-block; width: 10px; height: 10px; border-radius: 100%; background-color: {{ $order->status->color }}"></div>
                                            <p class="mg-0" style="display:inline-block;">{{ $order->status->name }}</p>
                                            @if($order->status->name == 'Payment Pending')
                                                <order-pay :order="{{ $order }}"></order-pay>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="col-xs-4">
                                        <p class="mg-0">Placed on {{ $order->formated_date }}</p>
                                    </td>
                                    <td class="col-xs-5">
                                        <p class="pull-right mg-0">Order #{{ $order->reference_number }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <order-show :order="{{ $order }}" 
                            :items="{{ $order->items }}" 
                            :address="{{ $order->address }}">
                </order-show>
            </div>
        </div>
    </div>
@endsection

@push('head_scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
