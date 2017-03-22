@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h4>Categories</h4>
                <h6><a href="#">Add a Category</a></h6>
                <ul>
                    @foreach($categories as $category)
                        <li>{{ $category->name }}
                            <ul>
                                @foreach($category->products as $product)
                                    <li>
                                        <h6>{{ $product->name }}</h6>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn btn-default">Edit</a>
                        <form method="POST" action="">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-default">Delete</button>
                        </form>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
