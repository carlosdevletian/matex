@extends('layouts.app')

@section('title')
    Shop
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($categories->count() > 0)
                    <h3 class="main-title">Shop through our available designs</h3>
                    @foreach($categories as $category => $designs)
                        <div class="row Card text-center position-relative pd-btm-50" v-cloak>
                            <h4 class="Card__title text-center">{{ ucfirst(str_plural($category)) }}</h4>
                            @foreach($designs as $design)
                                <design-show :design="{{ $design }}" add-class="col-xs-6 col-sm-4 col-md-3"></design-show>
                            @endforeach
                            <a class="Button--card stick-to-bottom" 
                                href="{{ route('shop-category.index', $designs->first()->category->slug_name) }}">
                                VIEW ALL
                            </a>
                        </div>
                    @endforeach
                @else
                    <h3 class="main-title">We don't have any products designed for you yet... But we're working on it!</h3>
                    <div class="text-center">
                        <h4>In the meantime, see what you can come up with</h4>
                        <br>    
                        <a class="Button--design" href="{{ route('categories.index') }}">Create your own</a>
                        <img src="{{ URL::to("images/matex2.png") }}" alt="pulsera" class="img-responsive center-block Login__logo" style="filter:none" onmousedown="return false">
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
