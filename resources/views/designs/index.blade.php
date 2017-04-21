@extends('layouts.app', ['backgroundColor' => 'grey-background'])

@section('title')
    Designs
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h1>Designs</h1>
                    <form method="GET" action="{{ route('designs.index') }}">
                        @foreach(request()->all() as $name => $value)
                            @unless($name == 'category')
                                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                            @endunless
                        @endforeach
                        <select name="category">
                            <option selected disabled>Filter by products</option>
                            <option value>All Designs</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug_name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-default">Go</button>
                    </form>
                </div>
                <div class="row">
                    @if($designs->count() > 0)
                        @foreach($designs as $design)
                            <design-show :design="{{ $design }}" add-class="col-xs-6 col-sm-4 col-md-3" admin="{{ auth()->user()->hasRole('admin') }}"></design-show>
                        @endforeach
                    @else
                        <h5>No Designs Created</h5>
                    @endif
                </div>
            </div>
            <div class="text-center">
                {{ $designs->links() }}
            </div>
        </div>
    </div>
@endsection
