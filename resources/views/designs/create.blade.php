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
            @if(auth()->check())
                @if(auth()->user()->designs->count() > 0)
                    <div class="panel panel-default">
                        <div class="panel panel-heading">Existing designs</div>
                            @foreach(auth()->user()->designs as $design)
                                <div class="panel-body" style="position: relative">
                                    <a href="#" 
                                    style="position: absolute; top: 0; right: 0; padding-right: 80px"
                                    class="load-design"
                                    data-target="{{ $design->views }}">
                                        Edit
                                        <!-- <i class="fa fa-pencil-square-o" aria-hidden="true"></i> -->
                                    </a>
                                    <a href="{{ route('order.create', ['category_id' => $category->id, 'design' => $design->id]) }}" 
                                        style="position: absolute; top: 0; right: 0; padding-right: 20px">
                                        Choose
                                        <!-- <i class="fa fa-sign-in" aria-hidden="true"></i> -->
                                    </a>
                                    <img src="{{ route('image_path', ['image' => $design->image_name]) }}" class="img img-responsive">
                                </div>
                            @endforeach
                    </div>
                @endif
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
