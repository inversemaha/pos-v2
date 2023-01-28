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
                            <form class="form-horizontal" method="post" action="/products/update"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">BarCode</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="barcode"
                                               value="{{$product->barcode}}">
                                               <input type="hidden" class="form-control" name="product_id"
                                               value="{{$product->product_id}}">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                               {{-- <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Name</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_name"
                                               value="{{$product->product_name}}">
                                        <input type="hidden" class="form-control" name="product_id"
                                               value="{{$product->product_id}}">
                                    </div>
                                </div>--}}

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Title</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_title"
                                               value="{{$product->product_title}}">
                                        <input type="hidden" class="form-control" name="product_details_id"
                                               value="{{$product->product_details_id}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Products Category</label>
                                    <div class="col-10">
                                        @if(isset($categories))

                                            @if(count($categories)<=0)
                                                <a href="/product/category/create" class="btn btn-info">+ Add
                                                    Category First To Continue</a>
                                            @else
                                                <select name="product_category_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    @foreach( $categories as $cat)
                                                        <option value="{{ $cat->product_category_id}}"
                                                                @if($cat->product_category_id==$product->product_category_id) selected @endif>
                                                            {{ $cat->product_category_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Image (600*600PX)</label>
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="image" id="img">

                                        <input type="hidden" class="form-control" name="image_name"
                                               value="{{$product->product_image}}">
                                    </div>
                                    {{-- <div class="col-5">
                                         <div class="col-md-6">
                                             <img id="blah" src="#" alt="Image" width="150px"/>
                                         </div>
                                     </div>--}}
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Description</label>
                                    <div class="col-10">
                                        <textarea type="text" class="form-control" name="product_description"
                                                  >{{$product->product_description}}</textarea>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Purchase Price</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_purchase_price"
                                               value="{{$product->product_purchase_price}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Retail Price</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="product_retail_price"
                                               value="{{$product->product_retail_price}}">
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

    {{--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script>
          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function (e) {
                      $('#blah').attr('src', e.target.result);
                  }

                  reader.readAsDataURL(input.files[0]);
              }
          }

          $("#img").change(function(){
              readURL(this);
          });
      </script>--}}
@endsection
