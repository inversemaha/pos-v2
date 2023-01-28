@extends('layouts.admin_layout')

@section('title', 'Show Operator')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Operator</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">View Operator</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{session('success')}}!</strong>
                </div>
            @endif
            @if(session('failed'))
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{session('failed')}}!</strong>
                </div>
            @endif
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>View Operator</h4>

                    </div>
                    <div class="col-sm-6">
                        <a href="/user/create" class="btn btn-sm btn-primary pull-right"><i
                                class="md md-add"></i> Add New</a>
                    </div>
                </div>

                <hr>
                @if(isset($result))
                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th> Email</th>
                            <th> Image</th>
                            <th> Phone</th>
                            <th>Type</th>
                            <th>User Company</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php($i=1)
                        @foreach($result as $res)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$res->user_name}}</td>
                                <td>{{$res->user_email}}</td>
                                <td><img src="/images/user/{{ $res->user_image }}" class="img-rounded"
                                         alt="User image" width="100"></td>
                                <td>{{$res->user_phone}}</td>
                                <td>
                                    @if($res->user_type==1)
                                        Admin
                                    @elseif($res->user_type==2)
                                        Operator
                                    @else
                                        Seller
                                    @endif
                                </td>
                                <td>{{$res->user_company}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-danger dropdown-toggle waves-effect waves-light"
                                            data-toggle="dropdown" aria-expanded="false">Action<span
                                            class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="/user/edit/{{$res->user_id}}"><i
                                                class="fa fa-edit"></i> Edit</a>
                                        {{--<a class="dropdown-item"
                                           href="/user/destroy/{{$res->user_id}}" ><i
                                                    class="fa fa-remove"></i> Delete</a>--}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!-- end row -->
        </div> <!-- end card-box -->
    </div><!-- end col -->

@endsection
