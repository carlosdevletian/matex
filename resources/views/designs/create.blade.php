@extends('layouts.app')

@section('title')
    Design your {{ $category->name }}
@endsection

@push('styles')
    <!-- Main CSS for the product designer -->
    <link rel="stylesheet" href="{{ URL::to('css/FancyProductDesigner-all.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::to('css/fpd.css') }}" />
@endpush

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="main-title">Design your {{ $category->name }}</h3>
                <div class="mg-btm-20">
                    @if(count($predesignedDesigns) > 0)
                        <button
                            @click="showPredesignedPicker = ! showPredesignedPicker; showDesignPicker = false"
                            class="Button--product--primary" v-bind:class="{ 'Button--product--primary--active' : showPredesignedPicker }">
                            Matex designs
                        </button>
                    @endif
                    @if(auth()->check() && auth()->user()->hasAnyDesignsInCategory($category->id))
                        <button 
                            @click="showDesignPicker = ! showDesignPicker; showPredesignedPicker = false"
                            class="Button--product" v-bind:class="{ 'Button--product--active' : showDesignPicker }">
                            Your designs
                        </button>
                    @endif
                </div>
                <design-picker :designs="{{ $predesignedDesigns }}" v-if="showPredesignedPicker" key="1"></design-picker>
                @if(auth()->check() && auth()->user()->hasAnyDesignsInCategory($category->id))
                    <design-picker :designs="{{ $existingDesigns }}" v-if="showDesignPicker" key="2"></design-picker>
                @endif
                <disclaimer></disclaimer>
                <fpd
                    template-directory="{{ URL::to('fpd') . '/'}}"
                    lang-json="{{ URL::to('default.json') }}"
                    :category-id="{{ $category->id }}"
                    :existing-design="{{ $design ? $design : '{}' }}"
                    existing-designs="{{ auth()->check() && auth()->user()->hasAnyDesignsInCategory($category->id) ? true : false }}"
                >
                    @include("fpd.{$category->slug_name}")
                </fpd>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Jquery UI -->
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Fabric.js  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.2/fabric.min.js" integrity="sha256-ZoIcsJVfAnLPf/ZgnJtJWarvXjiy4qBpTME0V1QLWD8=" crossorigin="anonymous"></script>

    <!-- FPD -->
    <script src="{{ URL::to('js/FancyProductDesigner-all.min.js') }}" type="text/javascript"></script>
@endpush
