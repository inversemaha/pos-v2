@extends('layouts.admin_layout')

@section('title', 'Create Stocks')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Stocks</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">New Stocks</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">New Stocks</h4>
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
                            <form class="form-horizontal" method="post" action="/stock/store"
                                  enctype="multipart/form-data">
                                  @csrf

                                

             

                                

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Title</label>
                                    <div class="col-10">
                                        @if(isset($data))

                                            @if(count($data)<=0)
                                                <a href="/products/create" class="btn btn-info">+ Add
                                                   Product First To Continue</a>
                                            @else
                                                <select name="product_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    <option>Select A Product First</option>
                                                    @foreach( $data as $product)
                                                        <option value="{{ $product->product_id}}">
                                                            {{ $product->product_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif

                                        @endif
                                    </div>
                                </div>

                                

                               


                                

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Quantity<span style="color: red"> *</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="quantity" required ">
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

    {{-- <script>

         function priceFormat(price) {
             if (/[^0-9.]/.test(price.value)) {
                 alert("Only Number and .");
                 price.value = price.value.substring(0, price.value.length - 1);
             }
        }
    </script> --}}

@endsection
