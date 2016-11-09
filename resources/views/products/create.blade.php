@extends('layouts.app')

@section('title')
    Create Product
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form method="post" action="{{ route('products.store') }}">
						<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
							<label for="title" class="control-label">{{ $errors->has('title') ? 'Input a valid title' : 'Title' }}</label>
							<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ Request::old('title') }}" required autofocus>
						</div>
						<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
							<label for="description" class="control-label">{{ $errors->has('description') ? 'Input a valid description' : 'Description' }}</label>
							<input type="text" class="form-control" name="description" id="description" placeholder="Description" value="{{ Request::old('description') }}" required>
						</div>
						{{ csrf_field() }}
						<button type="submit" class="btn btn-default btn-block">Create</button>
				</form>
			</div>
		</div>
	</div>
@endsection
