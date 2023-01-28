@extends('layouts.admin_layout')

@section('title', 'Edit Purchase')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Products</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Edit Purchase</a></li>
            </ol>

        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">Edit Purchase</h4>
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
                            <form class="form-horizontal" method="post" action="/ingredient/purchase/update"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Purpose</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="purpose" value="{{$purchase->purpose}}">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Measurement</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="measurement" value="{{$purchase->measurement}}">
                                        <input type="hidden" class="form-control" name="ingredient_id"
                                               value="{{$purchase->ingredient_id}}">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Total Price</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="total_price" value="{{$purchase->total_price}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Notes</label>
                                    <div class="col-10">
                                        <textarea type="text" class="form-control" name="notes">{{$purchase->notes}}</textarea>
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