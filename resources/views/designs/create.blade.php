@extends('layouts.app')

@section('title')
    Design your {{ $category->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h2>Design your {{ $category->name }}</h2>
            <ul>
                {{-- FPD --}}
            </ul>
        </div>
    </div>
@endsection
