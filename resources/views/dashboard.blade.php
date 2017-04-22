@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-12">
                <h3 class="main-title">Dashboard</h3>
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
            </div>
        </div>
    </div>
@endsection
