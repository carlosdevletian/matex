@extends('layouts.app')

@section('title')
    Products
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				@if(Auth::check())
                    <h1>Products <a href="{{ route('products.create') }}">+</a></h1>
                @else
                    <h1>Products</h1>
                @endif
				@foreach($products as $product)
					<div class="row">
						<div class="col-xs-9">
							<a href="{{ route('products.show', ['id' => $product->id]) }}">
								<h4>{{ $product->title }}</h4>
							</a>
							<h6>{{ $product->description }}</h6>
						</div>
						@if(Auth::check())
							<div class="col-xs-3">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-default btn-block">Edit</a>
								<form method="post" action="{{ route('products.destroy', $product->id) }}">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-default btn-block">Delete</button>
									<input type="hidden" name="_method" value="DELETE">
								</form>
							</div>
						@endif
					</div>
					<hr>
				@endforeach
				{{ $products->links() }}
			</div>
		</div>
	</div>
@endsection
