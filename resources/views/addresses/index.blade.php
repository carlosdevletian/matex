@extends('layouts.app')

@section('title')
    My Address Book
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h2>My Address Book</h2>
            @if($addresses->count() > 0)
                @foreach($addresses as $address)
                    <div class="col-xs-6">
                        <a href="{{ route('addresses.edit', ['address' => $address]) }}">
                            <div class="Card">
                                <h4>Recipient name: {{ $address->name }}</h4>
                                <h5>Street: {{ $address->street }}</h5>
                                <h5>City: {{ $address->city }}</h5>
                                <h5>State: {{ $address->state }}</h5>
                                <h5>Zip: {{ $address->zip }}</h5>
                                <h5>Country: {{ $address->country }}</h5>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <h5>No Addresses Created</h5>
            @endif
            <div class="text-center">
                {{ $addresses->links() }}
            </div>
        </div>
    </div>
@endsection
