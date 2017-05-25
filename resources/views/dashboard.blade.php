@extends('layouts.app')

@section('title')
    My Account
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-12">
                <h3 class="main-title">My account</h3>
                <div class="row">
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
                <img src="{{ URL::to("images/matex2.png") }}" alt="pulsera" class="img-responsive center-block Login__logo" style="filter:none" onmousedown="return false">
            </div>
        </div>
    </div>
@endsection
