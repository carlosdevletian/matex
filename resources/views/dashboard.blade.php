@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-12">
                <h1>Dashboard</h1>
                <h4>This is the dashboard</h4>
                <a href="{{ route('orders.index') }}" class="Button">My Orders</a>
                <br>
                <a href="{{ route('addresses.index') }}" class="Button">My Address Book</a>
                <br>
                <a href="{{ route('designs.index') }}" class="Button">My Designs</a>
            </div>
        </div>
    </div>
@endsection
