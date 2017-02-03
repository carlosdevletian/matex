@extends('layouts.app')

@section('title')

@endsection

@section('content')
    <div class="container" style="margin-top: 100px">
            <div class="row">
                <div style="margin-bottom: 20px; box-shadow: 5px 5px 5px #888888">
                    <img height="43px" width="1077px" src="{{ route('image_path', ['image' => $design->image_name]) }}" class="img img-responsive">
                </div>
            </div>
            <div class="row">
                <price-calculator
                    class="col-xs-6" style="background-color: white; box-shadow: 5px 5px 5px #888888; height: 60vh; overflow-y: scroll;"
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
                    style="background-color: white;"
                    v-if="stepTwo"
                    :email="guestEmail"
                    @address-selected="storeAddress"
                ></address-selector>
                <div v-if="stepThree">
                    <button class="btn btn-primary" @click="createOrder">Pay</button>
                </div>
                
            </div>
            {{-- asignar a usuario(user_id) o a guest(email) --}}
            {{-- mostrar total de la orden(subtotal, shipping, tax, total) --}}
            {{-- tiempo estimado de produccion --}}
            {{-- tiempo estimado de shipping --}}

            {{-- crear orden, con reference_number y pagar --}}

    </div>
@endsection
