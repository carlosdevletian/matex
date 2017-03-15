@extends('layouts.app')

@section('title')
    Edit Profile
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('users.update') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">

                            @if ($errors->count() > 0)
                                <span class="error">
                                    <strong>{{ $errors->first() }}</strong>
                                </span>
                            @endif

                            <div class="Input__icon">
                                <input id="name"
                                    type="text"
                                    name="name"
                                    class="Form {{ $errors->has('name') ? 'Form--error' : '' }}"
                                    placeholder="Name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    autofocus>
                            </div>

                            <div class="Input__icon">
                                <input id="email"
                                    type="email"
                                    name="email"
                                    class="Form {{ $errors->has('email') ? 'Form--error' : '' }}"
                                    placeholder="Email Address"
                                    value="{{ old('email', $user->email) }}"
                                    required>
                            </div>

                            <div class="Input__icon">
                                <input id="previous-password"
                                    type="password"
                                    class="Form {{ $errors->has('previous_password') ? 'Form--error' : '' }}"
                                    name="previous_password"
                                    placeholder="Old Password">
                            </div>

                            <div class="Input__icon">
                                <input id="password"
                                    type="password"
                                    class="Form {{ $errors->has('password') ? 'Form--error' : '' }}"
                                    name="password"
                                    placeholder="New Password">
                            </div>

                            <div class="Input__icon">
                                <input id="password-confirm"
                                    type="password"
                                    class="Form"
                                    name="password_confirmation"
                                    placeholder="Confirm New Password">
                            </div>

                            <button class="btn btn-default">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
