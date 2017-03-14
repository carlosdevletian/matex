@extends('layouts.app', ['backgroundColor' => 'blue-background'])

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <h1>Dashboard</h1>
            <div class="col-xs-12">
                @if($orders->count() > 0)
                    <div class="col-sm-6">
                        @include('widgets.orders')
                    </div>
                @endif
                <div class="col-sm-6">
                    @include('widgets.cart')
                </div>
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
