@extends('layouts.app')

@section('title')
    My Address Book
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h3 class="main-title">My Address Book</h3>
            @if($addresses->count() > 0)
                @foreach($addresses as $address)
                    <div class="col-sm-4">
                        <div class="Card position-relative pd-btm-50">
                            <h4 class="color-primary">{{ $address->name }}</h4>
                            <h5>{{ $address->street }}</h5>
                            <h5>{{ $address->city }}</h5>
                            <h5>{{ $address->state }}</h5>
                            <h5>{{ $address->zip }}</h5>
                            <h5>{{ $address->country }}</h5>
                            <a class="Button--card Button--card--left stick-to-bottom stick-to-bottom-left" href="{{ route('addresses.edit', ['address' => $address]) }}">Edit</a>
                            <form method="POST" 
                                action="{{ route('addresses.destroy', ['address' => $address]) }}" 
                                v-on:submit.prevent="deleteAddress($event)">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="Button--card Button--card--right stick-to-bottom">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="Card">
                    <h5>No Addresses Created</h5>
                </div>
            @endif
            <div class="text-center">
                {{ $addresses->links() }}
            </div>
        </div>
    </div>
@endsection
