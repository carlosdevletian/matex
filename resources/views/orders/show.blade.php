@extends('layouts.app')

@section('title')
    Order # {{ $order->id }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Order for {{ $order->address->name }}</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <img class="img-responsive" src="{{ route('image_path', ['image' => $item->design->image_name, 'forOrder' => true]) }}" alt="">
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                {{ $item->product->name }} {{ $item->product->category->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                ${{ $item->unit_price }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                {{ $item->quantity }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                {{ $item->total_price }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <ul>
                            <li>Subtotal {{ $order->subtotal }}</li>
                            <li>Shipping {{ $order->shipping }}</li>
                            <li>Tax {{ $order->tax }}</li>
                            <li>Total {{ $order->total }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
