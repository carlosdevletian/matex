@extends('layouts.app')

@section('title')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <img height="43px" width="1077px" src="{{ auth()->check() ? route('image_path', ['image' => $design->image_name]) : URL::to('designs/' . $design->image_name) }}" alt="">
            </div>
            <price-calculator
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
                v-if="stepTwo"
                :email="guestEmail"
                @address-selected="storeAddress"
            ></address-selector>
            <div v-if="stepThree">
                <button class="btn btn-primary" @click="createOrder">Pay</button>
            </div>
            {{-- <order
                v-if="stepThree"
                :items=orderItems
            ></order> --}}
            {{-- asignar a usuario(user_id) o a guest(email) --}}
            {{-- mostrar total de la orden(subtotal, shipping, tax, total) --}}
            {{-- tiempo estimado de produccion --}}
            {{-- tiempo estimado de shipping --}}

            {{-- crear orden, con reference_number y pagar --}}

        </div>
    </div>
@endsection
