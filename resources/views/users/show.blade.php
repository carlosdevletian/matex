@extends('layouts.app')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <h3 class="main-title text-center">{{ ucfirst($user->role->name) }} Profile</h3>
        @if($user->trashed())
            <h5 class="text-center color-red">This user was deleted on {{ $user->deleted_at->format('F j, Y') }}</h5>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="position-relative">
                    <div class="Card Card--dashboard pd-btm-50 scroll-y">
                        <p class="Card__title">Personal information</p>
                        <p>{{ $user->name }}</p>
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->business or '' }}</p>
                        <p>Joined: {{ $user->created_at->format('F j, Y') }}</p>
                        @unless(empty($user->creator))
                            <p>Created by: <a href="{{ route('users.show', ['user' => $user->creator_id ]) }}">{{ $user->creator->name }}</a></p>
                        @endunless
                        @include('admins.add-notes')
                    </div>
                    <a role="button" class="Button--card stick-to-bottom white-background" @click="openContactUserModal()">CONTACT USER</a>
                    <contact-user v-if="showContactUserModal" @close="closeContactUserModal()" :user="{{ $user }}"></contact-user>
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
