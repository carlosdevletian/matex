@extends('layouts.app')

@section('title')
    Matex
@endsection

@section('content')
    <div style="margin-top: -50px;"></div>

    @include('home/landing')

    @include('home/quote')

    @include('home/benefits')

@endsection
