@extends('layouts.admin_layout')

@section('title', 'Create User')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">User</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">New User</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">New User</h4>
                <hr>

                @if(session('success'))

                    <div class="alert alert-success">{{session('success')}}!</div>

                @endif
                @if(session('failed'))
                    <div class="alert alert-danger">
                        {{session('failed')}}!
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
                            <form class="form-horizontal" method="post" action="/user/store"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Name <span class="red-color">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_name">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Email</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_email" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Image</label>
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Phone<span class="red-color">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_phone" required>
                                    </div>
                                </div>
{{--

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Address</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_address">
                                    </div>
                                </div>
--}}

                              {{--  <div class="form-group row">
                                    <label class="col-2 col-form-label">Company</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="user_company">
                                    </div>
                                </div>--}}

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Password<span class="red-color">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="password" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Type</label>
                                    <div class="col-10">
                                        <select class="form-control" name="user_type">
                                            <option value="1">Admin</option>
                                            <option value="2">Operator</option>
                                            <option value="3">Seller</option>
                                        </select>
                                    </div>
                                </div>

                               {{-- <div class="form-group row">
                                    <label class="col-2 col-form-label">Select Role</label>
                                    <div class="col-10">
                                        <select class="form-control" name="role_id">
                                            @foreach($roles as $role)
                                                <option value="{{$role->role_id}}">{{$role->role_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>--}}


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