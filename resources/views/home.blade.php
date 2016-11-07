@extends('layouts.app')

@section('title')
    Test
@endsection

@section('content')
	<div class="container">
        <div class="row Section Section--main">
            <div class="col-xs-12">
                <h1>Base</h1>
                <h4>This is Base</h4>
            </div>
        </div>
        <div class="row Section">
            <div class="col-xs-12">
                <h1>Base</h1>
                <h4>This is Base</h4>
            </div>
        </div>
        @include('map')
        <div class="row Section">
            <div class="col-xs-12">
                @include('contact')
            </div>
        </div>
    </div>
@endsection
