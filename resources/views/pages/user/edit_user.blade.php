@extends('layouts.admin_layout')

@section('title', 'Edit Customer')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Customer</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Edit Customer</a></li>
            </ol>

        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">Edit Customer</h4>
                <hr>

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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-horizontal" method="post" action="/user/update"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Name</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_name"
                                               value="{{$result->user_name}}">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                        <input type="hidden" class="form-control" name="user_id"
                                               value="{{$result->user_id}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Email</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_email"
                                               value="{{$result->user_email}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Image</label>
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="image" id="img">

                                        <input type="hidden" class="form-control" name="image_name"
                                               value="{{$result->user_image}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Phone</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_phone"
                                               value="{{$result->user_phone}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Address</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_address"
                                               value="{{$result->user_address}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Company</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_company"
                                               value="{{$result->user_company}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">User Password</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="password" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Type{{$result->user_type}}</label>
                                    <div class="col-10">
                                        <select class="form-control" name="user_type">
                                            <option value="1" @if($result->user_type===1) selected @endif>Admin</option>
                                            <option value="2" @if($result->user_type===2) selected @endif>Operator</option>
                                            <option value="3" @if($result->user_type===3) selected @endif>Seller</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-0 justify-content-end row">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-info waves-effect waves-light">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div> <!-- end card-box -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

@endsection
