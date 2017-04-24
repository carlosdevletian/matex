@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-12">
                <h1>Dashboard</h1>
                <div class="row">
                    <div class="col-xs-4 Card pd-btm-50">
                        <h3 class="color-secondary">Orders</h3>
                        <a href="{{ route('orders.index') }}">Manage all orders</a>
                        <form class="form-horizontal" method="POST" action="{{ route('search.order') }}">
                            {{ csrf_field() }}

                            @if ($errors->has('reference'))
                                <span class="error">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif


                            <div class="Input__icon">
                                <label for="reference" class="control-label">Search</label>
                                <input id="reference"
                                    type="text"
                                    name="reference"
                                    class="Form {{ $errors->has('reference') ? 'Form--error' : '' }}"
                                    placeholder="Reference Number"
                                    value="{{ old('reference') }}"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                        </form>
                    </div>
                    <div class="col-xs-4 Card pd-btm-50">
                        <h3 class="color-secondary">Clients</h3>
                        <a href="{{ route('users.index') }}">View all clients</a>
                        <form class="form-horizontal" method="POST" action="{{ route('search.client') }}">
                            {{ csrf_field() }}

                            @if ($errors->has('email'))
                                <span class="error">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif


                            <div class="Input__icon">
                                <label for="email" class="control-label">Search</label>
                                <input id="email"
                                    type="text"
                                    name="email"
                                    class="Form {{ $errors->has('email') ? 'Form--error' : '' }}"
                                    placeholder="Client Email"
                                    value="{{ old('email') }}"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                        </form>
                    </div>

                    <div class="col-xs-4 Card pd-btm-50">
                        <h3 class="color-secondary">Products</h3>
                        <a href="{{ route('categories.create') }}">Create a new product category</a>
                        <br>
                        <a href="{{ route('categories.index') }}">Manage all products</a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-4 Card pd-btm-50">
                        <h3 class="color-secondary">Admins</h3>
                        <a href="#">Manage all administrators</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
