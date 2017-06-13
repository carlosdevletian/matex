@extends('layouts.app')

@section('title')
    Designs
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h3 class="main-title">Designs for {{ $category->name }}</h3>
                    @include('layouts.breadcrumbs', [
                        'links' => [
                            'Categories' => route('categories.index'),
                            ucfirst($category->name) => route('categories.edit', $category),
                            'active' => 'Designs'
                        ]
                    ])
                    <a href="{{ route('categories.add-design', compact('category'))}}" class="Button--product">Add a design</a>
                </div>
                @if($designs->count() > 0)
                    @foreach($designs as $design)
                        <design-show :design="{{ $design }}" add-class="col-xs-6 col-sm-4 col-md-3" admin="{{ admin() }}"></design-show>
                    @endforeach
                @else
                    <div class="Card">
                        <h5>No Designs for this category</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
