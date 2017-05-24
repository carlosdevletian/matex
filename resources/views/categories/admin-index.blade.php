@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <h3 class="main-title">Active Categories</h3>
                    @foreach($activeCategories as $category)
                        <category-show 
                            :category="{{ $category }}" 
                            image-path="{{ $category->imagePath() }}"
                            add-class="col-xs-6 col-sm-4 col-md-3"
                            is-admin="{{ admin() }}">
                        </category-show>
                    @endforeach
                </div>
                <hr>
                <div class="row">
                    <h3 class="main-title">Inactive Categories</h3>
                    @foreach($inactiveCategories as $category)
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
    </div>
@endsection
