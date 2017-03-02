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
            @if(auth()->check() && auth()->user()->hasAnyDesigns())
                <a role="button" v-if="!showDesignPicker" @click="showDesignPicker = true">Select from previous designs</a>
                <design-picker :designs="{{ auth()->user()->designs }}" v-if="showDesignPicker"></design-picker>
            @endif
            <h2>Design your {{ $category->name }}</h2>
            <fpd
                product-template="{{ URL::to('images/bracelet_template.png') }}"
                template-directory="{{ URL::to('fpd') . '/'}}"
                lang-json="{{ URL::to('default.json') }}"
                :category-id="{{ $category->id }}"
            ></fpd>
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
