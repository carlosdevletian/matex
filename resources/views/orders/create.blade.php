@extends('layouts.app')

@section('title')
    Make your Order
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="margin-bottom: 20px;">
                    <design-thumbnail image="{{ $design_image }}"></design-thumbnail>
                </div>
                <div>
                    <order-create
                        :products="{{ $products }}"
                        :addresses="{{ $addresses }}"
                        design="{{ $design }}"
                        category-id="{{ $categoryId or '' }}">
                    </order-create>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head_scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
