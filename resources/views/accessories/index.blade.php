@extends('layouts.app')

@section('title')
    Accessories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h3 class="main-title">Accessories for {{ $category->name }}</h3>
                    @include('layouts.breadcrumbs', [
                        'links' => [
                            'Categories' => route('categories.index'),
                            ucfirst($category->name) => route('categories.edit', $category),
                            'active' => 'Accessories'
                        ]
                    ])
                    <a href="{{ route('accessories.create', compact('category'))}}" class="Button--product">Add an accessory</a>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="main-title">Active Accessories</h4>
                            @foreach($activeAccessories as $accessory)
                                <accessory-show 
                                    :accessory="{{ $accessory }}" 
                                    image-path="{{ $accessory->imagePath() }}"
                                    add-class="col-xs-6 col-sm-4 col-md-3">
                                </accessory-show>
                            @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="main-title">Inactive Accessories</h4>
                            @foreach($inactiveAccessories as $accessory)
                                <accessory-show 
                                    :accessory="{{ $accessory }}" 
                                    image-path="{{ $accessory->imagePath() }}"
                                    add-class="col-xs-6 col-sm-4 col-md-3">
                                </accessory-show>
                            @endforeach</div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
