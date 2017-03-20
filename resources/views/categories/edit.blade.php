@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h4>Edit Category</h4>
                <form method="POST" action="{{ route('categories.update', ['category' => $category->id]) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    @if ($errors->count() > 0)
                        <span class="error">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif

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
                    
                    <ul>
                        @foreach($category->products as $product)
                            <li>
                                <div class="Input__icon">
                                    <label for="pname" class="control-label">Product</label>
                                    <input id="pname"
                                        type="text"
                                        name="pname"
                                        class="Form {{ $errors->has('pname') ? 'Form--error' : '' }}"
                                        placeholder="Product Name"
                                        value="{{ old('pname', $product->name) }}"
                                        required>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                <button class="btn btn-default">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
