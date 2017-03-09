@extends('layouts.email')

@section('greeting')
    Mail from: {{ $data['email'] }}
@endsection

@section('intro')
    {{ $data['subject'] }}
@endsection

@section('outro')
    {{ $data['body'] }}
@endsection
