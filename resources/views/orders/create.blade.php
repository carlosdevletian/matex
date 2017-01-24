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
                v-if="stepOne" 
                category-id="{{ $categoryId }}" 
                design-id="{{ $design->id }}"
                @step-one-incomplete="disableStepTwo"
                @enable-step-two="enableStepTwo"
                @item-updated="updateOrderItems" 
                @item-deleted="deleteItem" 
                @add-to-cart="addToCart"
            ></price-calculator>
            <address-selector 
                v-if="stepTwo"
                @address-selected="storeAddress"
            ></address-selector>
        </div>
    </div>
@endsection
