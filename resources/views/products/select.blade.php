@extends('layouts.app')

@section('title')
    Select the desired products
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h2>Your {{ $category->name }}</h2>
            <h5>With {{ $design->image_name }}</h5>
            <ul>
                @foreach($products as $product)
                    <li>
                        <div>
                            {{ $product->name }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
