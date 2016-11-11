@extends('layouts.app')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
                @unless(empty($product->file))
                    <img src="{{ URL::to( $product->file ) }}" alt="cover" class="img-responsive" width="100%" />
                @endif
				<h2>{{ $product->title }}</h2>
				<h4>{{ $product->description }}</h4>
				@if(Auth::check())
					<form method="post" action="{{ route('products.destroy', $product->id) }}">
						<a href="{{ route('products.edit', $product->id) }}" class="btn btn-default">Edit</a>
						{{ csrf_field() }}
						<button type="submit" class="btn btn-default">Delete</button>
						<input type="hidden" name="_method" value="DELETE">
					</form>
				@endif
			</div>
		</div>
	</div>
@endsection
