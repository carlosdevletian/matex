@extends('layouts.app')

@section('title')
    Your shopping cart
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your shopping cart.
                </div>
                @if($cart->items->count() > 0)
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th><div class="text-center">Price</div></th>
                                    <th><div class="text-center">Quantity</div></th>
                                    <th><div class="text-center">Total price</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td>
                                            <img height="300px" width="500px" src="{{ route('image_path', ['image' => $item->design->image_name]) }}" alt="">
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
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="pull-right">
                                Total: ${{ $cart->orderTotal() }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="pull-right">
                                <button class="btn btn-default">Proceed to checkout</button>
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="panel-body">
                            <div>There are no items in your cart.</div>
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
