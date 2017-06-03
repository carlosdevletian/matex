@extends('layouts.app')

@section('title')
    Accessory for {{ ucfirst($category->name) }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h3 class="main-title">{{ ucfirst($category->name) }}: Add an Accessory</h3>
                <form method="POST" action="{{ route('accessories.store', compact('category')) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif
                    
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <input type="file" name="file" id="file" class="dropify" data-height="115" data-max-file-size="10M" data-allowed-file-extensions="png jpg jpeg gif" data-show-remove="false"/>

                    <div class="Input__icon mg-top-10">
                        <label for="name" class="control-label">Accessory Name</label>
                        <input id="name"
                            type="text"
                            name="name"
                            class="Form {{ $errors->has('name') ? 'Form--error' : '' }}"
                            placeholder="Accessory Name"
                            value="{{ old('name') }}"
                            required
                            autofocus>
                    </div>
    
                    <div class="Input__icon">
                        <label for="price" class="control-label">Price</label>
                        <input id="price"
                            type="number"
                            name="price"
                            class="Form {{ $errors->has('price') ? 'Form--error' : '' }}"
                            placeholder="Price"
                            value="{{ old('price') }}"
                            required>
                    </div>

                    <div class="Input__icon">
                        <label for="active" class="control-label">
                        <input id="active"
                            type="checkbox"
                            name="active"
                            class="checkbox-inline"
                            value="true">  Check to make this accessory active
                        </label>
                    </div>

                    <div class="mg-top-10 mg-btm-20">
                        <button class="Button--primary">Add Accessory</button>
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
