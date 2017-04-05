@extends('layouts.app')

@section('title')
    Matex
@endsection

@section('content')

    <div style="margin-top: -50px;"></div>

    @include('home/landing')

    @include('home/services')

    @include('home/benefits')

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){ 
            $("#header-button").click(function() { 
                $("#navbar").toggleClass("navbar-home-click");
            });
        });
    </script>
@endpush
