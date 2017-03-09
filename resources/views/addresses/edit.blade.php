@extends('layouts.app')

@section('title')
    Edit Address
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Edit Address</h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('addresses.update', ['address' => $address]) }}">
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
                                value="{{ old('name', $address->name) }}"
                                required
                                autofocus>
                            </div>

                            <div class="Input__icon">
                                <input id="street"
                                type="text"
                                name="street"
                                class="Form {{ $errors->has('street') ? 'Form--error' : '' }}"
                                placeholder="Street"
                                value="{{ old('street', $address->street) }}"
                                required>
                            </div>

                            <div class="Input__icon">
                                <input id="city"
                                type="text"
                                name="city"
                                class="Form {{ $errors->has('city') ? 'Form--error' : '' }}"
                                placeholder="City"
                                value="{{ old('city', $address->city) }}"
                                required>
                            </div>

                            <div class="Input__icon">
                                <input id="state"
                                type="text"
                                name="state"
                                class="Form {{ $errors->has('state') ? 'Form--error' : '' }}"
                                placeholder="State"
                                value="{{ old('state', $address->state) }}"
                                required>
                            </div>

                            <div class="Input__icon">
                                <input id="zip"
                                type="text"
                                name="zip"
                                class="Form {{ $errors->has('zip') ? 'Form--error' : '' }}"
                                placeholder="Zip"
                                value="{{ old('zip', $address->zip) }}"
                                required>
                            </div>

                            <div class="Input__icon">
                                <input id="country"
                                type="text"
                                name="country"
                                class="Form {{ $errors->has('country') ? 'Form--error' : '' }}"
                                placeholder="Country"
                                value="{{ old('country', $address->country) }}"
                                required>
                            </div>

                            <div class="Input__icon">
                                <input id="phone_number"
                                type="text"
                                name="phone_number"
                                class="Form {{ $errors->has('phone_number') ? 'Form--error' : '' }}"
                                placeholder="Phone Number"
                                value="{{ old('phone_number', $address->phone_number) }}"
                                required>
                            </div>

                            <div class="Input__icon">
                                <textarea id="comment"
                                    type="text"
                                    name="comment"
                                    class="Form {{ $errors->has('comment') ? 'Form--error' : '' }}"
                                    placeholder="Comment"
                                    value="{{ old('comment', $address->comment) }}">
                                </textarea>
                            </div>

                            <button class="btn btn-default">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
