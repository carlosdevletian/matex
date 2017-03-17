@extends('layouts.app', ['backgroundColor' => 'orange-background'])

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
                <!-- falta editar perfil -->
            </div>
        </div>
    </div>
@endsection
