@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-12">
                <h3 class="main-title">Dashboard</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="col-xs-12 Card position-relative pd-btm-50">
                            <p class="Card__title">Orders</p>
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

                                <button type="submit" class="Button--card stick-to-bottom">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-xs-12 Card position-relative pd-btm-50">
                            <p class="Card__title">Clients</p>
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

                                <button type="submit" class="Button--card stick-to-bottom">Search</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="col-xs-12 Card position-relative pd-btm-50">
                            <p class="Card__title">Products</p>
                            <a href="{{ route('categories.create') }}">Create a new product category</a>
                            <br>
                            <a href="{{ route('categories.index') }}">Manage all categories</a>
                        </div>
                    </div>

                </div>
                @if(owner())
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-xs-12 Card position-relative pd-btm-50">
                                <p class="Card__title">Admins</p>
                                <a href="{{ route('admins.index') }}">Manage administrators</a><br>
                                <a href="{{ route('users.create') }}">Create a new user</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-xs-12 Card position-relative pd-btm-50">
                                <p class="Card__title">Peso colombiano</p>
                                <form class="form-horizontal" method="POST" action="{{ route('currency-rate.update', $rate) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <div class="Input__icon">
                                        <label for="rate" class="control-label">Cambio a USD</label>
                                        <input id="rate"
                                            type="text"
                                            name="to_dollar"
                                            class="Form {{ $errors->has('to_dollar') ? 'Form--error' : '' }}"
                                            placeholder="Cambio de peso a USD"
                                            value="{{ $rate->to_dollar }}"
                                            required>
                                    </div>

                                    <button type="submit" class="Button--card stick-to-bottom">Cambiar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
