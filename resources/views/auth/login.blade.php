@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
