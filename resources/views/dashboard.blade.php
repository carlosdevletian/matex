@extends('layouts.app', ['backgroundColor' => 'blue-background'])

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <h1>Dashboard</h1>
            <div class="col-xs-12">
                <div class="col-sm-6">
                    <h3>Shopping Cart</h3>
                    @include('widgets.cart')
                </div>
                @if($orders->count() > 0)
                    <div class="col-sm-6">
                        <h3>Active Orders</h3>
                        @include('widgets.orders')
                    </div>
                @endif
                @if(auth()->user()->hasAnyDesigns())
                    <div class="col-sm-12">
                        <h3>Recent designs</h3>
                        @include('widgets.designs')
                    </div>
                @endif()
                <!-- faltan addresss y editar perfil -->
            </div>
        </div>
    </div>
@endsection
