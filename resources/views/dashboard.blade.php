@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <h1>Dashboard</h1>
            <div class="col-xs-12">
                <div class="col-md-4">
                    @include('widgets.orders')
                </div>
                <div class="col-md-4">
                    @include('widgets.designs')
                </div>
                <div class="col-md-4">
                    @include('widgets.cart')
                    
                    @include('widgets.addresses')
                </div>
                <!-- falta editar perfil -->
            </div>
        </div>
    </div>
@endsection
