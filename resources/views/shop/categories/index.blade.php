@extends('layouts.app')

@section('title')
    Shop - {{ $category->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($designs->count() > 0)
                    <div class="row text-center">
                        <h3 class="main-title">{{ ucfirst(str_plural($category->name)) }}</h4>
                        <hr>
                        @foreach($designs as $design)
                            <design-show :design="{{ $design }}" add-class="col-xs-6 col-sm-4 col-md-3"></design-show>
                        @endforeach
                    </div>
                    <div class="text-center">
                        {{ $designs->links() }}
                    </div>
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
