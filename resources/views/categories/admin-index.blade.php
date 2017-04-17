@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <h4>Active Categories</h4>
                    @foreach($activeCategories as $category)
                        <category-show 
                            :category="{{ $category }}" 
                            image-path="{{ $category->imagePath() }}"
                            add-class="col-xs-6 col-sm-4 col-md-3">
                        </category-show>
                    @endforeach
                </div>
                <hr>
                <div class="row">
                    <h4>Inactive Categories</h4>
                    @foreach($inactiveCategories as $category)
                        <category-show 
                            :category="{{ $category }}" 
                            image-path="{{ $category->imagePath() }}"
                            add-class="col-xs-6 col-sm-4 col-md-3">
                        </category-show>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
