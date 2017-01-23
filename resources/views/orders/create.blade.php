@extends('layouts.app')

@section('title')
    
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <img height="300px" width="500px" src="{{ route('image_path', ['image' => $design->image_name]) }}" alt="">
            </div>
            <price-calculator 
                category-id="{{ $categoryId }}" 
                design-id="{{ $design->id }}"
                @item-updated="updateOrderItems" 
                @item-deleted="deleteItem" 
                @add-to-cart="addToCart"
                @display-addresses="showAddress = true" 
            ></price-calculator>
            <address-selector 
                v-show="showAddress"
                @address-selected="storeAddress"
            ></address-selector>
        </div>
    </div>
@endsection
