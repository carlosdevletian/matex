@extends('layouts.app')

@section('title')
    Edit Profile
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3 class="main-title text-center">Edit Profile</h3>
                <div class="Card position-relative" style="padding-bottom: 75px">
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
                            <input id="business"
                                type="text"
                                name="business"
                                class="Form {{ $errors->has('business') ? 'Form--error' : '' }}"
                                placeholder="Company Name (Optional)"
                                value="{{ old('business', $user->business) }}"
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

                        <button class="Button--primary stick-to-bottom">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
