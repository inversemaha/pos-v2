@extends('layouts.admin_layout')

@section('title', 'Create Product Discount')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Products</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">New Product Discount</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">New Product Discount</h4>
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
                            <form class="form-horizontal" method="post" action="/sell/discount/store"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <div class="col-10">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Select Product </label>
                                    <div class="col-10">
                                        @if(isset($category))

                                            @if(count($category)<=0)
                                                <a href="/products/create" class="btn btn-info">+ Add
                                                    Product First To Continue</a>
                                            @else
                                                <select name="product_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    <option>Select A Product First</option>
                                                    @foreach( $category as $cat)
                                                        <option value="{{ $cat->product_id}}">
                                                            {{ $cat->product_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif

                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Discount Rate</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="discount_rate">
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
