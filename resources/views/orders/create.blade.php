@extends('layouts.app', ['backgroundColor' => 'orange-background'])

@section('title')

@endsection

@section('content')
    <div class="pd-top-50">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div style="margin-bottom: 20px;">
                        <img src="{{ route('image_path', ['image' => $design_image]) }}" class="img img-responsive box-shadow margin-auto">
                    </div>
                    <div>
                        <create-order
                            :products="{{ $products }}"
                            :addresses="{{ $addresses }}"
                            design="{{ $design }}">
                        </create-order>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head_scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
