@extends('layouts.app')

@section('title')
    All Clients
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.css"/>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h4>All Clients</h4>
                <table class="table table-hover dt-responsive nowrap text-center" cellspacing="0" width="100%" id="users">
                    <thead>
                        <tr>
                            <th class="text-center">Email</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Business</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="{{ route('users.show', ['user' => $user]) }}">{{ $user->email }}</a></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->business or 'None' }}</td>
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
            $('#users').DataTable({
    			"responsive": true,
                "stateSave": true,
                "paging":   false,
                "info":     false,
    			"order": [[ 0, "asc" ]],
    			"columnDefs": [
    				{
    					"responsivePriority": 1,
    					"targets": 0
    				},
    	            {
    					"responsivePriority": 2,
    					"targets": 1
    				}
            	]
    		});
        });
    </script>
@endpush
