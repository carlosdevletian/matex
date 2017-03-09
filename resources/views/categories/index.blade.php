@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h4>Choose the product you wish to design</h4>
                <ul>
                    @foreach($categories as $category)
                        @if(empty($design))
                            <li><a href="{{ route('designs.create', ['category' => $category->slug_name] ) }}">{{ $category->name }}</a></li>
                        @else
                            <li><a href="{{ route('orders.create', ['category' => $category->slug_name, 'design' => $design]) }}">{{ $category->name }}</a>
                        @endif
                        <img height="200px" width="200px" class="img-responsive" src="categories/{{ $category->image_name }}">
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
