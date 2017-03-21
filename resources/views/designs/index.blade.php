@extends('layouts.app', ['backgroundColor' => 'orange-background'])

@section('title')
    My Designs
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h1>My Designs</h1>
            <div class="Card Card--half-pd col-xs-10 col-xs-offset-1">
                <div class="row">
                    @if($designs->count() > 0)
                        @foreach($designs as $design)
                            <design-show :design="{{ $design }}" add-class="col-xs-6 col-sm-4 col-md-3"></design-show>
                            <!-- <li>
                                <img src="{{ route('image_path', ['image' => $design->image_name]) }}" class="img img-responsive">
                                <a href="">Delete</a>
                                <a href="{{ route('categories.index', ['design' => $design->id]) }}">Order Again</a>
                            </li> -->
                        @endforeach
                    @else
                        <h5>No Designs Created</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
