@extends('layouts.admin_layout')

@section('title', 'Create Products Category')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Products Category</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">New Products Category</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('includes.message')
            <div class="card-box">
                <h4 class="m-t-0 header-title">New Products Category</h4>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-horizontal" method="post" action="/product/category/store"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Category Name</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_category_name">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Category Image</label>
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>

                                {{--<div class="form-group row">
                                    <label class="col-2 col-form-label">Select Outlet</label>
                                    <div class="col-10">
                                        <select class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
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
