@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h4>Choose the product you wish to design</h4>
                <ul>
                    @foreach($categories as $category)
                        <li><a href="{{ route('designs.create', [$category->id] ) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
