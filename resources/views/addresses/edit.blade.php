@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    Edit Address
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <h4 class="text-center">Edit Address</h4>
                <div class="Card position-relative" style="padding-bottom: 75px">
                    <form method="POST" 
                        action="{{ route('addresses.update', ['address' => $address]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

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
                        <button class="Button--primary stick-to-bottom">Update</button>
                    </form>
                    <form method="POST" 
                        action="{{ route('addresses.destroy', ['address' => $address]) }}" 
                        v-on:submit.prevent="deleteAddress($event)">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="color-red pull-right" 
                            style="border: none; background-color: transparent">Delete this address</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
