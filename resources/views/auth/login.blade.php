@extends('layouts.app')

@section('title')
    Login to Matex
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-5 col-md-6 hidden-xs">
            <img src="{{ URL::to("images/home/puls.png") }}" alt="pulsera" class="img-responsive center-block Login__image" onmousedown="return false">
        </div>
        <div class="col-md-5 col-sm-6">
            <img src="{{ URL::to("images/matex.png") }}" alt="pulsera" class="img-responsive center-block Login__logo" onmousedown="return false">
            <h3 class="main-title text-center">Login</h3>
            <div class="Card position-relative">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    
                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif

                    <div class="Input__icon">
                        <input id="email"
                            type="email"
                            name="email"
                            class="Form {{ $errors->has('email') ? 'Form--error' : '' }}"
                            placeholder="Email Address"
                            value="{{ old('email') }}"
                            required
                            v-focus>
                    </div>

                    <div class="Input__icon">
                        <input id="password" 
                            type="password"
                            class="Form {{ $errors->has('password') ? 'Form--error' : '' }}"
                            name="password"
                            placeholder="Password"
                            required>
                    </div>

                    <div class="form-group mg-btm-50">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="Button--primary stick-to-bottom">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
