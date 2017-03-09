@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-12">
                <h1>Dashboard</h1>
                <br>
                <a href="{{ route('carts.show') }}" class="Button">My Cart</a>
                <br>
                <a href="{{ route('orders.index') }}" class="Button">My Orders</a>
                <br>
                <a href="{{ route('addresses.index') }}" class="Button">My Address Book</a>
                <br>
                <a href="{{ route('designs.index') }}" class="Button">My Designs</a>
                <br>
                <a href="{{ route('users.edit', ['user' => auth()->user()->id]) }}" class="Button">Edit Profile</a>
            </div>
        </div>
    </div>
@endsection
