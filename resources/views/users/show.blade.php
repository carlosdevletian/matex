@extends('layouts.app')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center">{{ ucfirst($user->role->name) }} Profile</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="position-relative">
                    <div class="Card Card--dashboard pd-btm-50 scroll-y">
                        <p class="Card__title" style="margin-left: 15px">Personal information</p>
                        <p>{{ $user->name }}</p>
                        <p>{{ $user->email }}</p>
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
        @if(owner() && $user->hasRole('admin'))
            <div class="row">
                <div class="col-xs-12">
                    <form method="POST" action="{{ route('admins.delete', $user) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="Button--secondary pull-right">Delete this administrator</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
