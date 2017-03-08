@extends('layouts.app')

@section('title')
    My Designs
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>My Designs</h4>
                    </div>
                    <ul>
                        @if($designs->count() > 0)
                            @foreach($designs as $design)
                                <li>
                                    <img src="{{ route('image_path', ['image' => $design->image_name]) }}" class="img img-responsive">
                                    <a href="">Delete</a>
                                </li>
                            @endforeach
                        @else
                            <h5>No Designs Created</h5>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
