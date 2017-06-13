@extends('layouts.app')

@section('title')
    {{ ucfirst($category->name) }} - Products
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h3 class="main-title">Edit {{ ucfirst($category->name) }} Products</h3>
                    @include('layouts.breadcrumbs', [
                        'links' => [
                            'Categories' => route('categories.index'),
                            ucfirst($category->name) => route('categories.edit', $category),
                            'active' => 'Products'
                        ]
                    ])
                </div>
                <form method="POST" action="{{ route('categories.update-products', ['category' => $category->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif

                    <products :products="{{ $category->products }}"></products>
                    
                    <div class="col-sm-6 col-sm-offset-3 mg-top-10 mg-btm-20">
                        <button class="Button--primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('.dropify').dropify();
    </script>
@endpush
