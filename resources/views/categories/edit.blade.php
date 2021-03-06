@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h3 class="main-title">Edit {{ ucfirst($category->name) }}</h3>
                    @include('layouts.breadcrumbs', [
                        'links' => [
                            'Categories' => route('categories.index'),
                            'active' => ucfirst($category->name)
                        ]
                    ])
                    <div class="row">
                        <div class="col-xs-12">
                          <a href="{{ route('categories.edit-products', $category) }}" class="Button--product">Products</a>
                          <a href="{{ route('accessories.index', $category) }}" class="Button--product">Accessories</a>
                          <a href="{{ route('categories.designs', $category) }}" class="Button--product">Designs</a>
                          <a href="{{ route('pricings.index', $category) }}" class="Button--product">Pricing</a>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('categories.update', ['category' => $category->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif

                    <label for="file" class="control-label">Photo</label>
                    <input type="file" name="file" id="file" class="dropify" data-height="115" 
                                data-default-file="{{ $category->imagePath() }}" 
                                data-max-file-size="10M" 
                                data-allowed-file-extensions="png jpg jpeg gif" 
                                data-show-remove="false"/>

                    <div class="Input__icon">
                        <label for="name" class="control-label">Category Name</label>
                        <input id="name"
                            type="text"
                            name="name"
                            class="Form {{ $errors->has('name') ? 'Form--error' : '' }}"
                            placeholder="Category Name"
                            value="{{ old('name', $category->name) }}"
                            required
                            autofocus>
                    </div>
    
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="Input__icon">
                                <label for="cropw" class="control-label">Crop Width</label>
                                <input id="cropw"
                                    type="number"
                                    name="cropw"
                                    class="Form {{ $errors->has('cropw') ? 'Form--error' : '' }}"
                                    placeholder="Crop Width"
                                    value="{{ old('cropw', $category->crop_width) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="Input__icon">
                                <label for="croph" class="control-label">Crop Height</label>
                                <input id="croph"
                                    type="number"
                                    name="croph"
                                    class="Form {{ $errors->has('croph') ? 'Form--error' : '' }}"
                                    placeholder="Crop Height"
                                    value="{{ old('croph', $category->crop_height) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="Input__icon">
                                <label for="cropx" class="control-label">Crop X Position</label>
                                <input id="cropx"
                                    type="number"
                                    name="cropx"
                                    class="Form {{ $errors->has('cropx') ? 'Form--error' : '' }}"
                                    placeholder="Crop X Position"
                                    value="{{ old('cropx', $category->crop_x_position) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="Input__icon">
                                <label for="cropy" class="control-label">Crop Y Position</label>
                                <input id="cropy"
                                    type="number"
                                    name="cropy"
                                    class="Form {{ $errors->has('cropy') ? 'Form--error' : '' }}"
                                    placeholder="Crop Y Position"
                                    value="{{ old('cropy', $category->crop_y_position) }}"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="Input__icon">
                        <label for="disclaimer" class="control-label">Disclaimer</label>
                        <textarea class="Form"
                            id="disclaimer"
                            name="disclaimer"
                            placeholder="Add a disclaimer"
                            rows=4>{{ old('disclaimer', $category->disclaimer) }}</textarea>
                    </div>
                    
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
