@extends('layouts.app')

@section('title')
    All Admins
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.css"/>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="main-title">Administrators</h3>

                <table class="table table-hover dt-responsive nowrap text-center" cellspacing="0" width="100%" id="admins">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Created date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td><a href="{{ route('users.show', ['user' => $admin->id]) }}">{{ $admin->name }}</a></td>
                                <td>{{ $admin->created_at }}</td>
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
            $('#admins').DataTable({
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
