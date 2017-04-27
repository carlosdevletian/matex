@extends('layouts.app')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="page-header">
                    <h3 class="main-title">My Orders</h3>
                    <a href="{{ route('orders.index') }}" 
                        style="display: inline; padding-right: 10px" 
                        class="{{ request()->has('active') ?: 'color-secondary'}}">
                            All orders
                    </a>
                    <a href="{{ route('orders.index', ['active' => 1]) }}" 
                        style="display: inline; padding-right: 10px"
                        class="{{ ! request()->has('active') ?: 'color-secondary'}}">
                            Active orders
                    </a>
                </div>
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="row Card text-center">
                            <div class="row Card__header">
                                <div class="col-xs-4">
                                    <p>ORDER #</p>
                                    <p>{{ $order->reference_number }}</p>
                                </div>
                                <div class="col-xs-4">
                                    <p>PLACED</p>
                                    <p>{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="col-xs-4">
                                    <p>DELIVER TO</p>
                                    <a data-toggle="tooltip" data-placement="bottom" title="{{ $order->address->street }}, {{ $order->address->state }}. {{ $order->address->country }} ">{{ $order->address->name }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    @foreach($order->availableItems as $item)
                                        <div class="row" style="text-align: left">
                                            <div class="col-xs-12">
                                                <div @click="openImageModal({{ $item->design }})" class="background-image Thumbnail--image box-shadow Order__thumbnail"
                                                    style="background-image: url({{ route('image_path', ['image' => $item->design->image_name, 'forOrder' => 1]) }});
                                                            max-width: 100px;
                                                            margin-right: 15px;">
                                                </div>
                                                <div class="Order__index-price">
                                                    <p>{{ "{$item->quantity} {$item->product->name} " . str_plural($item->product->category->name, $item->quantity)  }}</p>
                                                    <p>${{ $item->unit_price / 100 }}</p>
                                                    <p><a class="Button--card" style="border: 1px solid" href="{{ route('orders.create', ['category' => $item->product->category->slug_name, 'design' => $item->design->id]) }}">ORDER AGAIN</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <p style="border: 2px solid {{ $order->status->color }}; border-radius: 5px; color:  {{ $order->status->color }}; padding: 8px;">
                                        {{ strtoupper($order->status->name) }}
                                    </p>
                                    <p>TOTAL: $ {{ $order->total }}</p>
                                </div>
                            </div>                             
                        </div>
                    @endforeach
                @else
                    <div class="Card">
                        <h5>No Orders Placed</h5>
                    </div>
                @endif
                <div class="text-center">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
@endsection
