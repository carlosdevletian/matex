@extends('layouts.app')

@section('title')
    Send Password Reset Mail
@endsection

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h3 class="main-title text-center">Reset your Password</h3>
            <div class="Card position-relative">
                <form class="form-horizontal mg-btm-50 mg-top-10" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="Button--primary stick-to-bottom">Send Password Reset Mail</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
