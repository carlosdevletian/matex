@extends('layouts.app')

@section('title')
    Register your Matex Account
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-5 col-md-6 hidden-xs">
            <img src="{{ URL::to("images/home/puls.png") }}" alt="pulsera" class="img-responsive center-block Login__image" onmousedown="return false">
        </div>
        <div class="col-md-5 col-sm-6">
            <img src="{{ URL::to("images/matex.png") }}" alt="pulsera" class="img-responsive center-block Login__logo" onmousedown="return false">
            <h4 class="main-title text-center">Register</h4>
            <div class="Card position-relative">
                <form class="form-horizontal" role="form" method="POST" action="{{ $token->exists ? route('store.client') : url('/register') }}">
                    {{ csrf_field() }}

                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif

                    @if($token->exists)
                        <input type="hidden" name="token" value="{{ $token->token }}">
                    @endif

                    <div class="Input__icon">
                        <input id="name"
                            type="text"
                            name="name"
                            class="Form {{ $errors->has('name') ? 'Form--error' : '' }}"
                            placeholder="Name"
                            value="{{ old('name') }}"
                            required
                            v-focus>
                    </div>

                    <div class="Input__icon">
                        <input id="email"
                            type="email"
                            name="email"
                            class="Form {{ $errors->has('email') ? 'Form--error' : '' }}"
                            placeholder="Email Address"
                            value="{{ $token->exists ? $token->email : old('email') }}"
                            required
                            {{ $token->exists ? 'readonly' : '' }}>
                    </div>

                    <div class="Input__icon">
                        <input id="password" 
                            type="password"
                            class="Form {{ $errors->has('password') ? 'Form--error' : '' }}"
                            name="password"
                            placeholder="Password"
                            required>
                    </div>

                    <div class="Input__icon" style="margin-bottom: 65px">
                        <input id="password-confirm" 
                            type="password"
                            class="Form"
                            name="password_confirmation"
                            placeholder="Confirm Password"
                            required>
                    </div>

                    <button type="submit" class="Button--primary stick-to-bottom">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
