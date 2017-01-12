@extends('layouts.app')

@section('title')
    Design your {{ $category->name }}
@endsection

@push('styles')
    <!-- Main CSS for the product designer -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to("css/FancyProductDesigner-all.min.css") }}" />
@endpush

@section('content')

    <div class="container">
        <div class="row">
            <h2>Design your {{ $category->name }}</h2>

            <div id="fpd">

            </div>

        </div>
    </div>
@endsection

@push('scripts')

    {{-- Jquery UI --}}
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    {{-- Fabric.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.2/fabric.min.js" integrity="sha256-ZoIcsJVfAnLPf/ZgnJtJWarvXjiy4qBpTME0V1QLWD8=" crossorigin="anonymous"></script>

    {{-- FPD --}}
    <script src="{{ URL::to("js/FancyProductDesigner-all.min.js") }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var $fpd = $('#fpd'),
                pluginOpts = {
                    stageWidth: 1200,
                    stageHeight: 800,
                    langJSON: "{{ URL::to('default.json') }}",
                    templatesDirectory: "{{ URL::to('fpd') . '/'}}",
                };

            var yourDesigner = new FancyProductDesigner($fpd, pluginOpts);
        });
    </script>
@endpush
