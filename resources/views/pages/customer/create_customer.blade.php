@extends('layouts.admin_layout')

@section('title', 'Create Customer')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Customer</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">New Customer</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('includes.message')
            <div class="card-box">
                <h4 class="m-t-0 header-title">New Customer</h4>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-horizontal" method="post" action="/customer/store"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Customer Name<span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="customer_name" required>
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Customer Email</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="customer_email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Customer Phone<span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="customer_phone" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Customer Address</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="customer_address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Customer Company</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="customer_company">
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
