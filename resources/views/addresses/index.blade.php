@extends('layouts.app')

@section('title')
    My Address Book
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>My Address Book</h4>
                    </div>
                    <ul>
                        @if($addresses->count() > 0)
                            @foreach($addresses as $address)
                                <li>
                                    <h4>{{ $address->name }}</h4>
                                    <h5>Street: {{ $address->street }}</h5>
                                    <h5>City: {{ $address->city }}</h5>
                                    <h5>State: {{ $address->state }}</h5>
                                    <h5>Zip: {{ $address->zip }}</h5>
                                    <h5>Country: {{ $address->country }}</h5>
                                </li>
                                <a href="">Edit</a>
                                <form method="POST" action="{{ route('addresses.destroy', ['address' => $address]) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-default">Delete</button>
                                </form>
                            @endforeach
                        @else
                            <h5>No Addresses Created</h5>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
