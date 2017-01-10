@extends('layouts.app')

@section('title')
    Order # {{ $order->id }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div>
                {{ $order->email }}
            </div>
            <div>
                {{ $order->address }}
            </div>
            <ul>
                @foreach($order->items as $item)
                    <li>
                        <div>
                            {{ $item->product->name }}
                        </div>
                        <div>
                            {{ $item->design->image_name }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
