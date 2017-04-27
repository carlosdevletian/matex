@extends('layouts.app')

@section('title')
    Designs
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h3 class="main-title">Designs</h3>
                    @include('designs.filters.all')
                </div>
                <div class="row">
                    @if($designs->count() > 0)
                        @foreach($designs as $design)
                            <design-show :design="{{ $design }}" add-class="col-xs-6 col-sm-4 col-md-3" admin="{{ auth()->user()->hasRole('admin') }}"></design-show>
                        @endforeach
                    @else
                        <div class="Card">
                            <h5>No Designs Created</h5>
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-center">
                {{ $designs->links() }}
            </div>
        </div>
    </div>
@endsection
