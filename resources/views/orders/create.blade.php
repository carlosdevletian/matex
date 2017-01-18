@extends('layouts.app')

@section('title')
    
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <img height="200px" width="200px" src="{{ route('image_path', ['image' => $design->image_name]) }}" alt="">
            </div>
            <price-calculator category-id="{{ $categoryId }}"></price-calculator>
            

            
        </div>
    </div>
@endsection
