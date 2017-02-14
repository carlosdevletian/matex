@extends('layouts.app')

@section('title')

@endsection

@section('content')
<div style=" padding-top: 50px;
    background-image: radial-gradient(circle, #f98927, #F16A01 60%);">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="margin-bottom: 20px;">
                    <img src="{{ route('image_path', ['image' => $design->image_name]) }}" class="img img-responsive">
                </div>
                <div>
                    <order 
                        :products="{{ $products }}" 
                        :addresses="{{ $addresses }}" 
                        :design-id="{{ $design->id }}">
                    </order>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div style=" padding-top: 100px;
    background-image: radial-gradient(circle, #f98927, #F16A01 60%);
    height: 100vh">
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-xs-12" style="margin-bottom: 20px;">
                <img src="{{ route('image_path', ['image' => $design->image_name]) }}" class="center-block img img-responsive" style="box-shadow: 5px 5px 5px #000000;">
            </div>
        </div>
        <div class="row">
            <price-calculator
                class="col-xs-6" style="background-color: white; box-shadow: 5px 5px 5px #000000; height: 70vh; overflow-y: scroll;"
                v-if="stepOne"
                :step-two="stepTwo"
                category-id="{{ $categoryId }}"
                design-id="{{ $design->id }}"
                @step-one-incomplete="disableStepTwo"
                @enable-step-two="enableStepTwo"
                @item-updated="updateOrderItems"
                @item-deleted="deleteItem"
                @add-to-cart="addToCart"
            ></price-calculator>
            <address-selector
                class="col-xs-6" 
                style="background-color: white; height: 70vh; overflow-y: scroll; box-shadow: 5px 5px 5px #000000;"
                v-if="stepTwo"
                :email="guestEmail"
                @address-selected="storeAddress"
            ></address-selector>
            <div v-if="stepThree">
                <button class="btn btn-primary" @click="createOrder">Pay</button>
            </div>
            
        </div>
            {{ asignar a usuario(user_id) o a guest(email) --}}
            {{-- mostrar total de la orden(subtotal, shipping, tax, total) --}}
            {{-- tiempo estimado de produccion --}}
            {{-- tiempo estimado de shipping --}}

            {{-- crear orden, con reference_number y pagar --}}
@endsection
