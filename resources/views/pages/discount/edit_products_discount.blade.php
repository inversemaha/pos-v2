@extends('layouts.admin_layout')

@section('title', 'Edit Products')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Products</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Edit Products</a></li>
            </ol>

        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">Edit Products</h4>
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

                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-horizontal" method="post" action="/sell/discount/update"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <div class="col-10">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-10">
                                        <input type="hidden" class="form-control" name="discount_id"
                                               value="{{$product->discount_id}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Select Product</label>
                                    <div class="col-10">
                                        @if(isset($categories))

                                            @if(count($categories)<=0)
                                                <a href="/products/create" class="btn btn-info">+ Add
                                                    Product First To Continue</a>
                                            @else
                                                <select name="product_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    @foreach( $categories as $cat)
                                                        <option value="{{ $cat->product_id}}"
                                                                @if($cat->product_id==$product->product_id) selected @endif>
                                                            {{ $cat->product_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Purchase Price</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="discount_rate"
                                               value="{{$product->discount_rate}}">
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

@endsection