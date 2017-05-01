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
                        <h4><a href="{{ route("orders.show", ['reference_number' => $order->reference_number ]) }}" class="color-primary">Order #{{ $order->reference_number }}</a></h4>
                        <div class="row Card text-center" style="margin-bottom: 50px">
                            <div class="row Card__header">
                                <div class="col-xs-4">
                                    <p>STATUS</p>
                                    <p style="color: {{ $order->status->color }}" data-toggle="tooltip" data-placement="bottom" title="{{ $order->status->name . " since " . $order->status->updated_at->diffForHumans() }}">
                                        {{ strtoupper($order->status->name) }}
                                    </p>
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
                                    @foreach($order->itemsGroupedByDesign() as $designImage => $itemCollection)
                                        <div class="row" style="text-align: left">
                                            <div class="col-xs-12">
                                                <div class="Order__thumbnail">
                                                    <div @click="openImageModal({{ $itemCollection->first()->design }})" class="background-image Thumbnail--image box-shadow"
                                                        style="background-image: url({{ route('image_path', ['image' => $designImage, 'forOrder' => 1]) }});
                                                                max-width: 90px;">
                                                    </div>
                                                    <a class="Button--order-item" style="border: 1px solid" href="{{ route('orders.create', ['category' => $itemCollection->first()->product->category->slug_name, 'design' => $itemCollection->first()->design->id ]) }}">ORDER AGAIN</a>
                                                </div>
                                                <div class="Order__index__detail">
                                                    @foreach($itemCollection as $item)
                                                        <div style="display:block; margin-bottom: 20px">
                                                            <p class="Order__index__amount">
                                                                {{ $item->quantity . " of " }}
                                                            </p>
                                                            <p class="Order__index__name">{{ $item->product->name . " " . str_plural($item->product->category->name, $item->quantity)  }}
                                                            </p>
                                                            <p class="Order__index__price">${{ $item->unit_price / 100 }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @unless($loop->last)
                                            <hr class="Order__hr">
                                        @endunless
                                    @endforeach
                                    <p class="Order__index__total">Total: ${{ $order->total }}</p>
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
