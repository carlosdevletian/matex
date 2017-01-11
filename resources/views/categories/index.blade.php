@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <ul>
                @foreach($categories as $category)
                    <li>
                        <div>
                            {{ $category->name }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
