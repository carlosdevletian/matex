@extends('layouts.app')

@section('title')
    Design your {{ $category->name }}
@endsection

@push('styles')
    <!-- Main CSS for the product designer -->
    <link rel="stylesheet" href="{{ URL::to('css/FancyProductDesigner-all.min.css') }}" />

    <style>
        .fpd-container>.fpd-main-wrapper {
            background-color: lightblue;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row">
            <h2>Design your {{ $category->name }}</h2>

            <div id="fpd" class="fpd-container fpd-topbar fpd-hidden-tablets">
                <div class="fpd-product" title="Titulo" data-thumbnail="http://bit.ly/2fiDvEl">
                    <img src= "{{ URL::to('images/bracelet_template.png') }}"
                         title="Bracelet"
                         data-parameters=
                            '{"left": 340, 
                            "top": 329, 
                            "draggable": false,
                            "removable": false,
                            "autoCenter": true,
                            "zChangeable": false,
                            "colors": "#ffffff,#e3e3e3,#000000,#ffff80,#ff6666,#00ff80",
                            "z": 2 
                            }'
                    />
                    <span title="Any Text" 
                          data-parameters=
                            '{"boundingBox": "Bracelet", 
                            "removable": true, 
                            "draggable": true, 
                            "rotatable": true, 
                            "resizable": true, 
                            "outOfBoundaryColor": "#FFFF00",
                            "autocenter": true,
                            "z": -1,
                            "colors": "#000000"}'
                    ></span>
                </div>
            </div>

            <button id="submit" class="btn btn-default pull-right">Submit</button>

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

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
            var $fpd = $('#fpd'),
                pluginOpts = {
                    stageWidth: 1200,
                    stageHeight: 600,
                    langJSON: "{{ URL::to('default.json') }}",
                    templatesDirectory: "{{ URL::to('fpd') . '/'}}",
                    actions:  {
                        'top': ['download', 'snap', 'preview-lightbox'],
                        'right': ['magnify-glass', 'zoom', 'reset-product'],
                        'bottom': ['undo','redo'],
                        'left': ['manage-layers','save']
                    },
                    customTextParameters: {
                        colors: "#000000,#ffffff",
                        removable: true,
                        resizable: true,
                        draggable: true,
                        rotatable: true,
                        autoCenter: true,
                        boundingBox: "Bracelet",
                        toolbarPlacement: "inside-top",
                        colors: "#e3e3e3,#000000,#ffff80,#ff6666,#00ff80",
                    },
                    customImageParameters: {
                        draggable: true,
                        removable: true,
                        resizable: true,
                        rotatable: true,
                        autoCenter: true,
                        boundingBox: "Bracelet",
                        z: -1,
                    },
                    outOfBoundaryColor: "#FF0000",
                    toolbarPlacement: "inside-top",
                };

            var yourDesigner = new FancyProductDesigner($fpd, pluginOpts);

            $('#submit').click(function(){
                yourDesigner.getProductDataURL(function(dataURL) {
                    $.post("/designs", { base64_image:  dataURL, category_id: {{ $category->id }} }, function(data) {
                        if(data) {
                            window.location = "/categories/" + data.category_id + "/designs/" + data.design_id + "/orders/create";
                        }
                        else {
                            // console.log('super peo');
                        }
                    });    
                });
            });
        });
    </script>
@endpush
