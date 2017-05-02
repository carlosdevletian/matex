@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="main-title">Choose the product you wish to design</h3>
                @foreach($categories as $category)
                    <category-show 
                        :category="{{ $category }}" 
                        image-path="{{ $category->imagePath() }}"
                        add-class="col-xs-6 col-sm-4 col-md-3"
                        is-admin="{{ admin() }}">
                    </category-show>
                @endforeach
            </div>
        </div>
    </div>
@endsection
