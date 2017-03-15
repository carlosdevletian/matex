@extends('layouts.app', ['backgroundColor' => 'blue-background'])

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <h1>Dashboard</h1>
            <div class="col-xs-12">
                <div class="col-md-6">
                    @include('widgets.orders')
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xs-12">
                            @include('widgets.cart')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            @include('widgets.addresses')
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    @include('widgets.designs')
                </div>
                <!-- faltan addresss y editar perfil -->
            </div>
        </div>
    </div>
@endsection
