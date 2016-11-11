@extends('layouts.app')

@section('title')
    Edit {{ $product->title }}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form id="form" method="post" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    <div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
						<label for="file" class="control-label">{{ $errors->has('title') ? 'Input a valid file' : 'Cover' }}</label>
                        @unless(empty($product->file))
						    <input type="file" name="file" id="file" class="dropify" data-height="115" data-default-file="{{ URL::to($product->file) }}" data-max-file-size="10M" data-allowed-file-extensions="png jpg jpeg gif"/>
    					@else
    						<input type="file" name="file" id="file" class="dropify" data-height="115" data-max-file-size="10M" data-allowed-file-extensions="png jpg jpeg gif"/>
    					@endif
					</div>
					<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
						<label for="title" class="control-label">{{ $errors->has('title') ? 'Input a valid title' : 'Title' }}</label>
						<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $product->title }}" required autofocus>
					</div>
					<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
						<label for="description" class="control-label">{{ $errors->has('description') ? 'Input a valid description' : 'Description' }}</label>
						<input type="text" class="form-control" name="description" id="description" placeholder="Description" value="{{ $product->description }}" required>
					</div>
					{{ csrf_field() }}
					<button type="submit" class="btn btn-default btn-block">Update</button>
					<input type="hidden" name="_method" value="PUT">
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var drEvent = $('.dropify').dropify();
        drEvent.on('dropify.afterClear', function(event, element){
            $('#form').append('<input type="hidden" name="remove-cover" value="1" />');
        });
	</script>
@endpush
