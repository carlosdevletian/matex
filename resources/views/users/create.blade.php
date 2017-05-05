@extends('layouts.app')

@section('title')
    Create a new User
@endsection

@section('content')
    <div class="container">
        <div class="row mg-top-10">
            <div class="col-sm-6 col-sm-offset-3">
                <h4>Create a new user</h4>
                <div class="Card position-relative pd-btm-50">
                    <form method="POST" action="{{ route('users.store') }}" v-on:submit.prevent="createUser($event)">
                        {{ csrf_field() }}

                        @if ($errors->count() > 0)
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="error text-center">
                                        <strong>{{ $errors->first() }}</strong>
                                    </span>
                                </div>
                            </div>
                        @endif
                        <input id="name"
                            type="text"
                            name="name"
                            class="Form {{ $errors->has('name') ? 'Form--error' : '' }} mg-btm-20"
                            placeholder="Name"
                            value="{{ old('name') }}"
                            required
                            autofocus>
                        <input id="email"
                            type="email"
                            name="email"
                            class="Form {{ $errors->has('email') ? 'Form--error' : '' }} mg-btm-20"
                            placeholder="Email Address"
                            value="{{ old('email') }}"
                            required>
                        <input id="password"
                            type="password"
                            class="Form {{ $errors->has('password') ? 'Form--error' : '' }} mg-btm-20"
                            name="password"
                            placeholder="User's password"
                            required>
                        <input id="password-confirm"
                            type="password"
                            class="Form mg-btm-20"
                            name="password_confirmation"
                            placeholder="Confirm the password">
                        <select name="role"  v-model="selectedRole" class="mg-btm-20">
                            <option disabled selected>Select a role for the new user</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        <button class="Button Button--primary stick-to-bottom color-white">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
