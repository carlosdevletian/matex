@extends('layouts.email')

@section('greeting')
    Correo de: {{ $data['email'] }}
@endsection

@section('intro')
    {{ $data['subject'] }}
@endsection

@section('outro')
    {{ $data['body'] }}
@endsection
