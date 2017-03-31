@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register New User</div>
                <div class="panel-body">
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

                        <div class="Input__icon">
                            <input id="password-confirm" 
                                type="password"
                                class="Form"
                                name="password_confirmation"
                                placeholder="Confirm Password"
                                required>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
