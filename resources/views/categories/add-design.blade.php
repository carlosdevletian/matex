@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3 class="main-title">{{ ucfirst($category->name) }}: Add a design</h3>
                <form method="POST" action="{{ route('categories.store-design', compact('category')) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif
                    
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <input type="file" name="file" id="file" class="dropify" data-height="115" data-max-file-size="10M" data-allowed-file-extensions="png jpg jpeg gif" data-show-remove="false"/>

                    <div class="mg-top-10 mg-btm-20">
                        <button class="Button--primary">Add Design</button>
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
