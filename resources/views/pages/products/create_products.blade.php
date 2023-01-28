@extends('layouts.admin_layout')

@section('title', 'Create Products')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Products</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{__("message.NEWPRODUCTS")}}</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">{{__("message.NEWPRODUCTS")}}</h4>
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
                            <form class="form-horizontal" method="post" action="/products/store"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.BarCode')}}</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="barcode" value="{{getQrCode()}}">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                              {{--  <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Name<span style="color: red"> *</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_name"required>
                                    </div>
                                </div>--}}


                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.ProductTitle')}}<span style="color: red"> *</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_title" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.ProductsCategory')}}</label>
                                    <div class="col-10">
                                        @if(isset($category))

                                            @if(count($category)<=0)
                                                <a href="/product/category/create" class="btn btn-info">+ Add
                                                    Category First To Continue</a>
                                            @else
                                                <select name="product_category_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    <option>Select A Category First</option>
                                                    @foreach( $category as $cat)
                                                        <option value="{{ $cat->product_category_id}}">
                                                            {{ $cat->product_category_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif

                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.ProductImage')}} (600*600PX)</label>
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.ProductDescription')}}</label>
                                    <div class="col-10">
                                        <textarea type="text" class="form-control" name="product_description"></textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.PurchasePrice')}}<span style="color: red"> *</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_purchase_price" onkeyup="priceFormat(this)">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{__('message.RetailPrice')}}<span style="color: red"> *</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_retail_price" required onkeyup="priceFormat(this)">
                                    </div>
                                </div>

                                <div class="form-group mb-0 justify-content-end row">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-info waves-effect waves-light">{{__('message.Save')}}
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

    <script>

         function priceFormat(price) {
             if (/[^0-9.]/.test(price.value)) {
                 alert("Only Number and .");
                 price.value = price.value.substring(0, price.value.length - 1);
             }
        }
    </script>

@endsection
