@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1>My Orders</h1>
                <a href="#" style="display: inline; padding-right: 10px">All orders</a>
                <a href="#" style="display: inline; padding-right: 10px">Active orders</a>
            </div>
            <div class="col-xs-10 col-xs-offset-1">
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="Card col-md-12">
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
                            <div class="row">
                                @foreach($order->items as $item)
                                    <div class="row" style="display: flex; align-items: center">
                                        <div class="background-image Thumbnail--image box-shadow"
                                            style="background-image: url({{ route('image_path', ['image' => $item->design->image_name, 'forOrder' => 1]) }});
                                                    max-width: 100px;
                                                    margin-right: 15px">
                                        </div>
                                        <div style="">
                                            <p class="mg-0">{{ "{$item->quantity} {$item->product->name} " . str_plural($item->product->category->name, $item->quantity)  }}</p>
                                            <p class="mg-0">${{ $item->unit_price / 100 }}</p>
                                            <p class="mg-0"><a href="{{ route('orders.create', ['category' => $item->product->category->slug_name, 'design' => $item->design->id]) }}">Order again</a></p>
                                        </div>
                                    </div>
                                    @if(! $loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5>No Orders Placed</h5>
                @endif
            </div>
        </div>
    </div>
@endsection
