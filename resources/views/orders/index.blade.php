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
                        <div class="Card Card--double-pd col-md-12">
                            <div class="row white-background" style="margin: -20px -50px 30px -50px; border-bottom: solid 2px rgb(221, 221, 221); padding: 14px 18px">
                                <div class="col-xs-9">
                                    <div class="table-responsive borderless">
                                        <table class="table borderless mg-0 pd-0">
                                            <tr class="pd-0 mg-0">
                                                <td class="pd-0 mg-0 col-xs-3">
                                                    <p class="text-center mg-0">ORDER PLACED</p>
                                                </td>
                                                <td class="pd-0 mg-0 col-xs-2">
                                                    <p class="text-center mg-0">TOTAL</p>
                                                </td>
                                                <td class="pd-0 mg-0 col-xs-7">
                                                    <p class="text-center mg-0">DELIVER TO</p>
                                                </td>
                                            </tr>
                                            <tr class="pd-0 mg-0">
                                                <td class="pd-0 mg-0 col-xs-3">
                                                    <p class="text-center mg-0">{{ $order->created_at->diffForHumans() }}</p>
                                                </td>
                                                <td class="pd-0 mg-0 col-xs-2">
                                                    <p class="text-center mg-0">${{ $order->total / 100 }}</p>
                                                </td>
                                                <td class="pd-0 mg-0 col-xs-7">
                                                    <p class="text-center mg-0">{{ $order->address->name }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="row pd-0 mg-0"><p class="text-center pd-0 mg-0">ORDER # {{ $order->reference_number }}</p></div>
                                    <div class="row pd-0 mg-0"><p class="text-center pd-0 mg-0"><a href="{{ route('orders.show', $order->reference_number) }}">Order details</a></p></div>
                                </div>
                            </div>
                            <div class="row position-relative">
                                <div class="col-xs-8">
                                    @foreach($order->availableItems as $item)
                                        <div class="row position-relative" style="display: flex; align-items: center">
                                            <div class="background-image Thumbnail--image box-shadow"
                                                style="background-image: url({{ route('image_path', ['image' => $item->design->image_name, 'forOrder' => 1]) }});
                                                        max-width: 100px;
                                                        margin-right: 15px">
                                            </div>
                                            <div class="position-relative">
                                                <p>{{ "{$item->quantity} {$item->product->name} " . str_plural($item->product->category->name, $item->quantity)  }}</p>
                                                <p>${{ $item->unit_price / 100 }}</p>
                                                <p><a class="Button--card" style="border: 1px solid" href="{{ route('orders.create', ['category' => $item->product->category->slug_name, 'design' => $item->design->id]) }}">ORDER AGAIN</a></p>
                                            </div>
                                        </div>
                                        @unless($loop->last)
                                            <br>
                                        @endunless
                                    @endforeach
                                </div>
                                <div class="col-xs-4 text-center" style="position: absolute; height: 100%; display: flex; justify-content: center; flex-direction: column; right: 0;">
                                    <p style="border: 2px solid {{ $order->status->color }}; border-radius: 5px; color:  {{ $order->status->color }}; padding: 8px;">
                                        {{ strtoupper($order->status->name) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5>No Orders Placed</h5>
                @endif
                <div class="text-center">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
@endsection
