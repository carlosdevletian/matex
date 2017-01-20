@extends('layouts.app')

@section('title')
    
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <img height="300px" width="500px" src="{{ route('image_path', ['image' => $design->image_name]) }}" alt="">
            </div>
            <price-calculator category-id="{{ $categoryId }}" @item-updated="updateOrderItems" @item-deleted="deleteItem"></price-calculator>


        </div>
    </div>
@endsection
