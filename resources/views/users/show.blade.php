@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center">User Profile</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="position-relative">
                    <div class="Card Card--dashboard pd-btm-50 scroll-y">
                        <p class="Card__title" style="margin-left: 15px">Personal information</p>
                        <p>{{ $user->name }}</p>
                        <p>{{ $user->email }}</p>
                        @include('admin.add-notes')
                    </div>
                    <a role="button" class="Button--card stick-to-bottom white-background">CONTACT USER</a>
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
