@extends('layouts.app')

@section('title')
    {{ ucfirst($category->name) }} - Pricing 
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3 class="main-title">{{ ucfirst($category->name) }} - Pricing </h3>
                @include('layouts.breadcrumbs', [
                        'links' => [
                            'Categories' => route('categories.index'),
                            ucfirst($category->name) => route('categories.edit', $category),
                            'active' => 'Pricings'
                        ]
                    ])
                <a role="button" class="Button--product" @click="showCreatePricing = true">Add a new price range</a>
            </div>
            <div class="col-xs-12">
                <div class="Card position-relative pd-btm-50  mg-top-10">
                    @if ($errors->any())
                        <div class="error">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('pricings.update') }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="borderless position-relative">
                            <table class="table borderless mg-0">
                                <tbody>
                                    <tr>
                                        <th class="text-center">From</th>
                                        <th class="text-center">Unit Price</th>
                                    </tr>
                                    @foreach($pricings as $pricing)
                                        <tr class="text-center">
                                            <td class="col-xs-3">
                                                <input style="width: 100%" 
                                                    class="Form pd-0 text-center" 
                                                    type="number" 
                                                    name="pricings[{{ $pricing->id }}][min_quantity]" 
                                                    value="{{ $pricing->min_quantity }}">
                                            </td>
                                            <td class="col-xs-3">
                                                <float-input 
                                                    name="pricings[{{ $pricing->id }}][unit_price]" 
                                                    classes="Form pd-0 text-center" 
                                                    value="{{ $pricing->unit_price }}">
                                                </float-input>
                                            </td>
                                            <td class="col-xs-1">
                                                <pricing-delete :pricing="{{ $pricing }}"></pricing-delete>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button class="Button--secondary stick-to-bottom" type="submit">Submit</button>
                    </form>
                    <pricing-create :category="{{ $category }}" v-if="showCreatePricing" @close="showCreatePricing = false"></pricing-create>
                </div>
            </div>
        </div>
    </div>
@endsection
