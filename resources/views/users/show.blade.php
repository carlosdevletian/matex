@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center">User Profile</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="Card position-relative pd-btm-50">
                    <h3 class="text-center color-primary">Personal information</h3>
                    <p>{{ $user->name }}</p>
                    <p>{{ $user->email }}</p>
                    @include('admin.add-notes')
                    <button class="Button--primary stick-to-bottom">Send an email to this user</button>
                </div>
            </div>
            <div class="col-md-4">
                @include('widgets.orders', ['orders' => $user->orders()->with('status')->get(), 'profileUser' => $user])
            </div>
            <div class="col-md-4">
                @include('widgets.designs', ['designs' => $user->recentDesigns(), 'profileUser' => $user])
            </div>
        </div>
    </div>
@endsection
