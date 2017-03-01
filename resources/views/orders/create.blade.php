@extends('layouts.app')

@section('title')

@endsection

@section('content')
    <div style=" padding-top: 50px;
        background-image: radial-gradient(circle, #f98927, #F16A01 60%);">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div style="margin-bottom: 20px;">
                        <img src="{{ route('image_path', ['image' => $design_image]) }}" class="img img-responsive">
                    </div>
                    <div>
                        <order
                            :products="{{ $products }}"
                            :addresses="{{ $addresses }}"
                            design="{{ $design }}">
                        </order>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
