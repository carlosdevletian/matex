@extends('layouts.app')

@section('title')
    All Orders
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.css"/>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="main-title">Orders 
                    {{ request()->has('client') ? 'by ' . request()->client : '' }}
                </h3>

                <form method="GET" action="{{ route('orders.index') }}" class="mg-btm-20">
                    @foreach(request()->all() as $name => $value)
                        @unless($name == 'status')
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endunless
                    @endforeach
                    <div class="Form__select mg-rgt-10">
                        <select name="status">
                            <option selected disabled>Filter Orders</option>
                            <option value>All Orders</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="Button--product">Go</button>
                    <a class="Button--product" href="{{ route('orders.index') }}" style="padding: 7px; display: inline-block;">Reset Filters</a>
                </form>

                <table class="table table-hover dt-responsive nowrap text-center" cellspacing="0" width="100%" id="orders">
                    <thead>
                        <tr>
                            <th class="text-center">Reference Number</th>
                            <th class="text-center">Client</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Date Placed</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', ['order' => $order->reference_number]) }}">{{ $order->reference_number }}</a></td>
                                <td>{{ $order->email or $order->user->email }}</td>
                                <td>{{ $order->present()->total }} $</td>
                                <td>{{ $order->created_at->format('d M y') }}</td>
                                <td><i class="fa fa-circle" style="color:{{ $order->status->color }}; font-size: 15pt;" data-toggle="tooltip" data-placement="bottom" title="{{ $order->status->name  . ' since ' . $order->status->updated_at->toDateString() }}" aria-hidden="true"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.12/filtering/type-based/accent-neutralise.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#orders').DataTable({
    			"responsive": true,
                "paging":   false,
                "info":     false,
    			"order": [[ 3, "desc" ]],
    			"columnDefs": [
    				{
    					"responsivePriority": 1,
    					"targets": 0
    				},
    	            {
    					"responsivePriority": 2,
    					"targets": 4
    				},
    				{
    					"type": "alt-string",
    					"targets": 4
    				}
            	]
    		});
        });
    </script>
@endpush
