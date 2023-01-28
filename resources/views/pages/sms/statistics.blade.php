@extends('layouts.app')

@section('content')

    <div class="col-10 mx-auto">
        <div class="card" style="margin-top: 20px">
            <div class="card-body">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($result as $res)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$res->name}}</td>
                            <td>{{$res->phone}}</td>
                            <td>{{$res->message}}</td>
                            <td>{{ date('Y-m-d',strtotime($res->created_at))}}</td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endsection